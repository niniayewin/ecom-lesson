<?php

namespace App\Http\Controllers;
use App\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrders(Request $request){
        $myDate=$request['filter_by_date'];
        $myMonth=$request['filter_by_month'];

        if($myDate){
            $today=date('Y-m-d',strtotime($myDate));
        }elseif ($myMonth){
           $today=$request['filter_by_month'] ;
        }else{
            $today=date('Y-m-d');
        }
        $orders=Orders::where("created_at","LIKE","%$today%")
            ->OrderBy('id','desc')
            ->get();
        return view('Categories.orders')->with(['orders'=>$orders]);
    }
    public function getDeliver($id){
        $order=orders::whereId($id)->firstOrFail();
        $order->status=1;
        $order->update();
        return redirect()->back();

    }
}
