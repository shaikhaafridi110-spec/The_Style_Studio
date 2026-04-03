<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{


  public function adminhome()
{
    // ======================
    // 📊 CARDS DATA
    // ======================
    $user = User::count();
    $product = Product::count();
    $order = Order::count();
    $revenue = Order::sum('final_amount');

    $delivered = Order::where('status', 'delivered')->count();
    $pending = Order::where('status', 'pending')->count();

    // ======================
    // 📊 WEEK (LAST 7 DAYS)
    // ======================
    $days = [];
    $sales = [];
    $orders = [];
    $conversion = [];

    $data = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(final_amount) as total_sales')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(6))
        ->groupBy('date')
        ->pluck('total_sales', 'date')
        ->toArray();

    $orderCount = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(6))
        ->groupBy('date')
        ->pluck('total_orders', 'date')
        ->toArray();

    for ($i = 6; $i >= 0; $i--) {

        $date = Carbon::now()->subDays($i)->format('Y-m-d');
        $dayName = Carbon::parse($date)->format('D');

        $days[] = $dayName;

        $sale = $data[$date] ?? 0;
        $orderVal = $orderCount[$date] ?? 0;

        $sales[] = (int)$sale;
        $orders[] = (int)$orderVal;

        $conversion[] = $orderVal > 0 
            ? round(($orderVal / max($user,1)) * 100, 2) 
            : 0;
    }

    // ======================
    // 📊 TODAY (HOURLY)
    // ======================
    $todayData = Order::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('SUM(final_amount) as total_sales'),
            DB::raw('COUNT(*) as total_orders')
        )
        ->whereDate('created_at', Carbon::today())
        ->groupBy('hour')
        ->orderBy('hour')
        ->get();

    $todayLabels = [];
    $todaySales = [];
    $todayOrders = [];
    $todayConversion = [];

    for ($h = 0; $h < 24; $h++) {

        $label = date('ga', strtotime("$h:00"));
        $found = $todayData->firstWhere('hour', $h);

        $todayLabels[] = $label;
        $todaySales[] = $found->total_sales ?? 0;
        $todayOrders[] = $found->total_orders ?? 0;

        $todayConversion[] = ($found && $found->total_orders > 0)
            ? round(($found->total_orders / max($user,1)) * 100, 2)
            : 0;
    }

    // ======================
    // 📊 MONTH (WEEK-WISE)
    // ======================
    $monthData = Order::select(
        DB::raw('CEIL(DAY(created_at)/7) as week'),
        DB::raw('SUM(final_amount) as total_sales'),
        DB::raw('COUNT(*) as total_orders')
    )
    ->whereMonth('created_at', date('m'))
    ->groupBy('week')
    ->orderBy('week')
    ->get();

$monthLabels = [];
$monthSales = [];
$monthOrders = [];
$monthConversion = [];

foreach ($monthData as $m) {
    $monthLabels[] = 'Week '.$m->week; // Week 1,2,3,4
    $monthSales[] = $m->total_sales;
    $monthOrders[] = $m->total_orders;

    $monthConversion[] = $m->total_orders > 0
        ? round(($m->total_orders / max($user,1)) * 100, 2)
        : 0;
}
    // ======================
    // 📊 YEAR (12 MONTHS)
    // ======================
    $yearData = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(final_amount) as total_sales'),
            DB::raw('COUNT(*) as total_orders')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $yearLabels = [];
    $yearSales = [];
    $yearOrders = [];
    $yearConversion = [];

    for ($m = 1; $m <= 12; $m++) {

        $yearLabels[] = date('M', mktime(0,0,0,$m,1));

        $found = $yearData->firstWhere('month', $m);

        $sale = $found->total_sales ?? 0;
        $orderVal = $found->total_orders ?? 0;

        $yearSales[] = (int)$sale;
        $yearOrders[] = (int)$orderVal;

        $yearConversion[] = $orderVal > 0
            ? round(($orderVal / max($user,1)) * 100, 2)
            : 0;
    }

    // ======================
    // 🔥 TOP PRODUCTS
    // ======================


$topProducts = OrderItem::select(
        'products.proid',
        'products.proname',
        DB::raw('SUM(order_items.qty) as total')
    )
    ->join('products', 'products.proid', '=', 'order_items.product_id')
    ->groupBy('products.proid', 'products.proname')
    ->orderByDesc('total')
    ->limit(5)
    ->get();
   

    // ======================
    // 🧾 RECENT ORDERS
    // ======================
    $recentOrders = Order::latest()->limit(5)->get();

    // ======================
    // RETURN VIEW
    // ======================
    return view('admin.index', compact(
        'user','product','order','revenue',
        'delivered','pending',

        // WEEK
        'days','sales','orders','conversion',

        // TODAY
        'todayLabels','todaySales','todayOrders','todayConversion',

        // MONTH
        'monthLabels','monthSales','monthOrders','monthConversion',

        // YEAR
        'yearLabels','yearSales','yearOrders','yearConversion',

        // EXTRA
        'topProducts','recentOrders'
    ));
}

    //*******user******
    public function adminuser(Request $req)
    {
        //$data=emp::get();
        $name = $req->search;
        $data = User::select('*')->where('role', 2);
        if ($name != "") {
            $data->where('name', 'like', '%' . $name . '%');
        }
        if ($req->userid != "") {
            $data->where('id', $req->userid);
        }
        $data = $data->paginate(10)->withQueryString();
        //return view('user',);
        return view('admin/user', compact('data'));
    }
    public function user_del($id)
    {
        User::where('id', $id)->delete();
        return redirect('admin/user')->with('success', 'User Deleted Successfully');
    }
    public function edit_user($id)
    {
        $data = User::select('*')->where('id', $id)->first();
        return view('admin/edit_user', compact('data'));
    }
    public function update_user(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'address_line1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'email' => 'required|email',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $data = User::find($id);

        $data->name = $req->name;
        $data->email = $req->email;
        $data->phone = $req->phone;
        $data->address_line1 = $req->address_line1;
        $data->address_line2 = $req->address_line2;
        $data->city = $req->city;
        $data->state = $req->state;
        $data->postal_code = $req->postal_code;


        $data->birthdate = $req->birthdate;
        $data->gender = $req->gender;

        $data->save();

        return redirect('admin/user')->with('success', 'User Updated Successfully');
    }
}
