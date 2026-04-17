<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function orderlist(Request $r)
    {
        $data = Order::with('user')->orderBy('created_at', 'desc');
    $date=Order::select('order_date')->distinct()->groupBy('order_date')->orderBy('order_date','desc')->get();

        if ($r->status) {
            $data->where('status', $r->status);
        }

        if ($r->payment_status) {
            $data->where('payment_status', $r->payment_status);
        }
        if($r->date){
                 $d = date('Y-m-d', strtotime($r->date));
                $data->whereDate('order_date', $d );
        }

        $data = $data->paginate(10);

        return view('admin.order', compact('data', 'date'));
    }

    // ================= DELETE =================
    public function order_del($id)
    {
        Order::find($id)->delete();
        return redirect('admin/Order')->with('success', 'Deleted');
    }

    // ================= EDIT =================
    public function order_edit($id)
    {
       $order = Order::with('user', 'items.product')->find($id);

   

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }
        return view('admin.orderitems', compact('order'));
    }

    // ================= UPDATE =================
    public function order_update(Request $r, $id)
{

    $r->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'status' => 'required',
        'payment_status' => 'required',
    ]);

    
    $order = Order::with('user')->find($id);

    if (!$order) {
        return redirect()->back()->with('error', 'Order not found');
    }

    // ================= ORDER UPDATE =================
    $order->name = $r->name;
    $order->phone = $r->phone;
    $order->status = $r->status;
    $order->payment_status = $r->payment_status;
    $order->notes = $r->notes;

   
    $order->address_line1 = $r->address_line1;
    $order->tracking_number = $r->tracking_number;

    $order->save();

    // ================= USER UPDATE =================
    if ($order->user) {
        $order->user->email = $r->email;
        $order->user->save();
    }

    // ================= REDIRECT =================
    return redirect('admin/Order')->with('success', 'Order Updated Successfully!');
}

    // ================= ORDER ITEMS =================
    public function orderitems()
    {
        $data = OrderItem::with('order', 'product')->paginate(5);
        return view('admin.orderitems', compact('data'));
    }

    public function orderitem_del($id)
    {
        OrderItem::find($id)->delete();
        return redirect('admin/Order-items')->with('success', 'Deleted');
    }





    // ─────────────────────────────────────────────────────────
    // 1. MY ORDERS LIST
    // ─────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest('order_date');
 
        // Filter by status (optional)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
 
        $orders = $query->paginate(8)->withQueryString();
 
        return view('user.order', compact('orders'));
    }
 
    // ─────────────────────────────────────────────────────────
    // 2. ORDER DETAIL / STATUS
    // ─────────────────────────────────────────────────────────
    public function show($orderId)
    {
        $order = Order::with('items')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
 
        return view('user.ordershow', compact('order'));
    }
} 
// public function orderlist(Request $r)
//     {
//         $data=Order::with('user')->orderBy('created_at','desc');
//         $date=Order::select('order_date')->distinct()->groupBy('order_date')->orderBy('order_date','desc')->get();
        
//             if($r->date){
//                  $d = date('Y-m-d', strtotime($r->date));
//                 $data->whereDate('order_date', $d );
//             }
//             if($r->status){
//                 $data->where('status', $r->status);
//             }
//             if($r->payment_status){
//                 $data->where('payment_status', $r->payment_status);
//             }
//             if($r->order_id){
//                 $data->where('id', $r->order_id);
//             }
//         $data=$data->paginate(10);
//         return view('admin.order',compact('data', 'date'));
//     }
//     public function order_del($id)
//     {
//         $data=Order::find($id);
//         $data->delete();
//         return redirect('admin/Order')->with('success','Order Deleted Successfully');
//     }
//     public function order_user(Request $r)
//     {
//         $data=$r;
     

//         return view('admin.order_user',compact('data'));
//     }





//    