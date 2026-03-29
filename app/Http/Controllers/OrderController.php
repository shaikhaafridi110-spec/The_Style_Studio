<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //orders
    public function orderlist(Request $r)
    {
        $data=Order::with('user')->orderBy('created_at','desc');
        $date=Order::select('order_date')->distinct()->groupBy('order_date')->orderBy('order_date','desc')->get();
        
            if($r->date){
                 $d = date('Y-m-d', strtotime($r->date));
                $data->whereDate('order_date', $d );
            }
            if($r->status){
                $data->where('status', $r->status);
            }
            if($r->payment_status){
                $data->where('payment_status', $r->payment_status);
            }
            if($r->order_id){
                $data->where('id', $r->order_id);
            }
        $data=$data->paginate(10);
        return view('admin.order',compact('data', 'date'));
    }
    public function order_del($id)
    {
        $data=Order::find($id);
        $data->delete();
        return redirect('admin/Order')->with('success','Order Deleted Successfully');
    }
    public function order_user(Request $r)
    {
        $data=$r;
     

        return view('admin.order_user',compact('data'));
    }





    //order items
    public function orderitems()
    {
        $data=OrderItem::with('order', 'product')->paginate(5);
      
        return view('admin.orderitems',compact('data'));
    }
    public function orderitem_del($id)
    {
        $data=OrderItem::find($id)->delete();
     
        return redirect('admin/Order-items')->with('success','Order Item Deleted Successfully');
    }

}
