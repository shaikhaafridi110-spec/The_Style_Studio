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
            'catid' => 'required',
            'proimage' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $imageName = time() . '_' . uniqid() . '.' . $res->proimage->getClientOriginalExtension();
        $res->proimage->move(public_path('admin/assets/images/products'), $imageName);


        $product = Product::create([
            'proname' => $res->proname,
            'description' => $res->description,
            'price' => $res->price,
            'discount_price' => $res->discount_price,
            'catid' => $res->catid,
            'proimage' => 'products/' . $imageName
        ]);


        if ($res->hasFile('images')) {
            $sort = 1;

            foreach ($res->file('images') as $img) {

                $imgName = time() . '_' . rand() . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('admin/assets/images/products'), $imgName);

                ProductImage::create([
                    'proid' => $product->proid,
                    'image' => 'products/' . $imgName,
                    'sort_order' => $sort++
                ]);
            }
        }


        if ($res->size) {

            foreach ($res->size as $size) {

                $stock = isset($res->stock[$size]) ? (int)$res->stock[$size] : 0;

                if ($stock > 0) {
                    Productsize::create([
                        'proid' => $product->proid,
                        'size' => $size,
                        'stock' => $stock
                    ]);
                }
            }
        }

        return redirect('admin/product')->with('success', 'Product Added Successfully!');
    }

    public function product_delete($id)
    {
        $product = Product::findOrFail($id);
        $images = ProductImage::where('proid', $id)->get();

        foreach ($images as $img) {

            $path = public_path('admin/assets/images/' . $img->image);

            if (file_exists($path)) {
                unlink($path); // delete file
            }

            $img->delete(); // delete DB
        }

       
        if ($product->proimage) {
            $mainPath = public_path('admin/assets/images/' . $product->proimage);

            if (file_exists($mainPath)) {
                unlink($mainPath);
            }
        }

       
        Productsize::where('proid', $id)->delete();

        
        $product->delete();

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
    public function updateProduct(Request $res, $id)
    {
        $pro = Product::findOrFail($id);

        // UPDATE BASIC
        $pro->update([
            'proname' => $res->proname,
            'description' => $res->description,
            'price' => $res->price,
            'discount_price' => $res->discount_price,
            'catid' => $res->catid,
        ]);

        // MAIN IMAGE UPDATE
        if ($res->hasFile('proimage')) {
            $img = time() . '.' . $res->proimage->extension();
            $res->proimage->move('admin/assets/images/products', $img);

            $pro->proimage = 'products/' . $img;
            $pro->save();
        }

        // ADD NEW IMAGES
        if ($res->hasFile('images')) {
            foreach ($res->file('images') as $img) {
                $name = time() . rand() . '.' . $img->extension();
                $img->move('admin/assets/images/products', $name);

                ProductImage::create([
                    'proid' => $pro->proid,
                    'image' => 'products/' . $name
                ]);
            }
        }


        if ($res->size) {

            foreach ($res->size as $size) {

                $qty = isset($res->stock[$size]) ? (int)$res->stock[$size] : 0;

                if ($qty <= 0) continue;

                $ps = Productsize::where('proid', $id)
                    ->where('size', $size)
                    ->first();

                if ($ps) {

                    $ps->stock += $qty;
                    $ps->save();
                } else {

                    Productsize::create([
                        'proid' => $id,
                        'size' => $size,
                        'stock' => $qty
                    ]);
                }
            }
        }

        return redirect('admin/product')->with('success', 'Updated!');
    }

    public function deleteProductImage($id)
    {
        $img = ProductImage::findOrFail($id);


        $path = public_path('admin/assets/images/' . $img->image);

        if (file_exists($path)) {
            unlink($path);
        }


        $proid = $img->proid;
        $img->delete();


        return redirect('admin/edit-product/' . $proid)
            ->with('success', 'Image deleted successfully!');
    }
}
