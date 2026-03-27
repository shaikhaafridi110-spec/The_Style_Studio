<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Productsize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminProductController extends Controller
{
    public function product(Request $r)
    {

        $products = Product::select('*');
        $cat = Category::select('id', 'name')->get();
        $proname = $r->search;
        $prostatus = $r->status;
        if ($proname != '') {
            $products->where('proname', 'like', '%' . $proname . '%');
        }
        if ($prostatus != '') {
            $products->where('status', $prostatus);
        }
        if ($r->category != '') {
            $products->where('catid', $r->category);
        }
        $products = $products->paginate(5)->withQueryString();
        return view('admin/product', compact('products', 'cat'));
    }
    public function addproduct()
    {
        $data = Category::select('id', 'name')->where('status', '1')->get();
        return view('admin.add-product', compact('data'));
    }
    public function saveproduct(Request $res)
    {
        $res->validate([
            'proname' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:1',
            'discount_price' => '',
            'catid' => 'required',
            'proimage' => 'required|image|mimes:jpg|max:2048'
        ]);
        $imageName = time() . '_' . uniqid() . '.' . $res->proimage->getClientOriginalExtension();

        $res->proimage->move(public_path('admin/assets/images/products'), $imageName);

        Product::create([
            'proname' => $res->proname,
            'description' => $res->description,
            'price' => $res->price,
            'discount_price' => $res->discount_price,
            'catid' => $res->catid,
            'proimage' => 'products/' . $imageName
        ]);
        return redirect('admin/product')->with('success', 'Product Added Successfully!');
    }

    public function product_delete($id)
    {
        Product::find($id)->delete();
        return redirect('admin/product')->with('success', 'Product Deleted Successfully!');
    }
    public function product_status($id)
    {
        $pro = Product::find($id);
        if ($pro->status == 'active') {
            $pro->status = 'inactive';
        } else {
            $pro->status = 'active';
        }

        $pro->save();
        return redirect('admin/product')->with('success', 'Product satatus updated successfully!');
    }
    public function product_edit($id)
    {
        $pro = Product::find($id);
        $data = Category::select('id', 'name')->where('status', '1')->get();
        return view('admin/edit-product', compact('pro', 'data'));
    }
    public function updateProduct(Request $r, $id)
    {


        $pro = Product::find($id);
        $r->validate([
            'proname' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:1',
            'discount_price' => '',
            'catid' => 'required',
            'proimage' => 'image|mimes:jpg|max:2048'
        ]);

        $pro->proname = $r->proname;
        $pro->description = $r->description;
        $pro->discount_price = $r->discount_price;
        $pro->price = $r->price;
        $pro->catid = $r->catid;

        if ($r->proimage != '') {
            $imageName = time() . '_' . uniqid() . '.' .  $r->proimage->getClientOriginalExtension();

            $r->proimage->move(public_path('admin/assets/images/products'), $imageName);

            $pro->proimage = 'products/' . $imageName;
        }
        $pro->save();
        return redirect('admin/product')->with('success', 'Product updated successfully!');
    }




    //produc image


    public function productimage(Request $r)
    {
        $query = ProductImage::with('product')->orderby('proid', 'asc')->orderby('sort_order', 'asc');
        $pro = Product::has('images')->where('status', 'active')->get();
        $proname = $r->product;

        if ($proname != '') {
            $query->where('proid', $proname);
        }




        $productImages = $query->paginate(5)->withQueryString();

        return view('admin.product-images', compact('productImages', 'pro'));
    }



    public function addproductimage()
    {
        $products = Product::where('status', 'active')->get();

        return view('admin.add-product-image', compact('products'));
    }
    public function saveproductimage(Request $r)
    {

        $r->validate([
            'proid' => 'required|exists:products,proid',
            'image.*' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $sort = 1;
        foreach ($r->file('image') as $img) {

            $imageName = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();


            $img->move(public_path('admin/assets/images/products'), $imageName);


            ProductImage::create([
                'proid' => $r->proid,
                'image' => 'products/' . $imageName,
                'sort_order' => $sort
            ]);
            $sort++;
        }

        return redirect('admin/product-image')
            ->with('success', 'Multiple Product Images Added Successfully!');
    }
    public function editProductImage($id)
    {
        $image = ProductImage::find($id);
        $products = Product::where('status', 'active')->get();

        return view('admin.edit-product-image', compact('image', 'products'));
    }
    public function updateProductImage(Request $r, $id)
    {
        $image = ProductImage::find($id);

        if ($r->hasFile('image')) {


            $oldPath = public_path('admin/assets/images/products/' . $image->image);

            if (file_exists($oldPath)) {
                unlink($oldPath);
            }


            $imageName = time() . '_' . uniqid() . '.' .  $r->image->getClientOriginalName();

            $r->image->move(
                public_path('admin/assets/images/products'),
                $imageName
            );

            $image->image = "products/" . $imageName;
        }

        $image->proid = $r->proid;
        $image->sort_order = $r->sort_order;
        $image->save();

        return redirect('admin/product-image')
            ->with('success', 'Image Updated Successfully');
    }
    public function deleteProductImage($id)
    {
        $image = ProductImage::find($id);
        $image->delete();

        return redirect()->back()
            ->with('success', 'Image Deleted Successfully');
    }






    //product-size

    public function productsize()
    {
        $products = Productsize::with('product')->select('proid');
        $groupproduct = $products->groupBy('proid');

        $groupproduct = $groupproduct->paginate(5)->withQueryString();

        return view('admin/product-sizes', compact('groupproduct'));
    }

    public function addproductsize()
    {
        $products = Product::where('status', 'active')->get();
        return view('admin/add-product-size', compact('products'));
    }

    public function saveproductsize(Request $res)
    {
        $res->validate([
            'proid' => 'required|exists:products,proid',
            'size' => 'required|in:S,M,L,XL,XXL,28,30,32,34,36,38',
            'stock'  => 'required|integer|min:1',
        ]);

        $productSize = ProductSize::where('proid', $res->proid)
            ->where('size', $res->size)
            ->first();

        if ($productSize) {
            // record exists
            $productSize->stock += $res->stock;
            $productSize->save();
            return Redirect('admin/product-size')->with('success', 'Stock updated successfully!');
        } else {

            ProductSize::create([
                'proid' => $res->proid,
                'size'  => $res->size,
                'stock'   => $res->stock,
            ]);

            return Redirect('admin/product-size')->with('success', 'Size added successfully!');
        }
    }
    public function updatestock(Request $r)
    {
        foreach ($r->size as $key => $size) {

            $stock = $r->stock[$key];

            if ($stock > 0) {
                ProductSize::where('proid', $r->proid[$key])
                    ->where('size', $size)
                    ->increment('stock', $stock);
            }
        }
        return Redirect('admin/product-size')->with('success', 'Stock updated successfully');
    }
    public function deletesize($id)
    {   
        
        Productsize::find($id)->delete();  
       return Redirect('admin/product-size')->with('success', 'Stock updated successfully');
    }
}
