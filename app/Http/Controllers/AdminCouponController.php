<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class AdminCouponController extends Controller
{
    // LIST PAGE
    public function coupon(Request $r)
    {
        $data = Coupon::select('*');

        if ($r->search != '') {
            $data->where('code', 'like', '%' . $r->search . '%');
        }

        if ($r->status != '') {
            $data->where('status', $r->status);
        }

        $data = $data->paginate(5)->withQueryString();

        return view('admin.coupon', compact('data'));
    }

    // ADD PAGE
    public function addCoupon()
    {
        return view('admin.add-coupon');
    }

    // SAVE
    public function saveCoupon(Request $req)
    {
        $req->validate([
            'code' => 'required|unique:coupons,code',
            'discount' => 'required|numeric',
            'type' => 'required',
        ]);

        Coupon::create([
            'code' => $req->code,
            'discount' => $req->discount,
            'type' => $req->type,
            'expiry_date' => $req->expiry_date,
            'usage_limit' => $req->usage_limit,
        ]);

        return redirect('admin/coupon')->with('success', 'Coupon Added!');
    }

    // EDIT PAGE
    public function editCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.edit-coupon', compact('coupon'));
    }

    // UPDATE
    public function updateCoupon(Request $req, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->update([
            'code' => $req->code,
            'discount' => $req->discount,
            'type' => $req->type,
            'expiry_date' => $req->expiry_date,
            'usage_limit' => $req->usage_limit,
        ]);

        return redirect('admin/coupon')->with('success', 'Updated!');
    }

    // DELETE
    public function deleteCoupon($id)
    {
        Coupon::where('coupon_id', $id)->delete();
        return back()->with('success', 'Deleted!');
    }

    // STATUS
    public function status($id)
    {
        $c = Coupon::find($id);
        $c->status = $c->status == '1' ? '0' : '1';
        $c->save();

        return back()->with('success', 'Status Updated!');
    }
}
