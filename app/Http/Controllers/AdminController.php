<?php

namespace App\Http\Controllers;
use App\Models\Products;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        return view('Dashboard.index');
    }

    public function products(){
        $products = Products::all(); //Products is model name
        return view('Dashboard.products',compact('products'));
    }

    public function customers(){
        $customers = User::all(); //User is model name
        return view('Dashboard.customers',compact('customers'));
    }
    public function deleteUser($id)
    {
        $customer = User::find($id);
        $customer->delete();
        return redirect()->back()->with('success', 'Congratulation!  Customer Listing Deleted Successfully');
    }
    public function orders(){
        // $orderItems = OrderItem::all();
        $orderItems = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', 'products.gallery', 'order_items.*')
            ->get();
            $orders = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'users.user_name', 'users.email')
            ->get();
        return view('Dashboard.orders', compact('orders','orderItems'));
    }
    
    public function changeOrderStatus($status,$id){
        $order = Order::find($id);
        $order->payment_status = $status;
        $order->save();
        return redirect()->back()->with('success','Congratulation! payment status Updated Successfully');
    }
}