<?php

namespace App\Http\Controllers;
use App\Post;
use App\Poster;
use App\Cart;
use App\Orders;
use App\Orderitem;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ForntendController extends Controller
{
    public function postCheckout(Request $request){
        $this->validate($request,[
            'phone'=>'required',
            'address'=>'required'
        ]);
        $order=new Orders();
        $order->user_id=Auth::id();
        $order->phone=$request['phone'];
        $order->address=$request['address'];
        $order->save();
        $items=Session::get('cart')->posts;
        foreach ($items as $i){
            $order_item = new Orderitem();
            $order_item->order_id = $order->id;
            $order_item->item_name = $i['post']['item_name'];
            $order_item->price = $i['post']['price'];
            $order_item->qty = $i['qty'];
            $order_item->amount = $i['amount'];
            $order_item->save();

        }
        Session::forget('cart');
        return redirect()->back()->with('info','The order item have been checkout');
    }
    public function getshoppingCard(){
        return view('shopping-cart');
    }
    public function addToCart($id){
        $post=Poster::whereId($id)->firstOrFail();
        $oldPost=Session::has('cart') ? Session::get('cart') : null;
        $cart=new Cart($oldPost);
        $cart->add($post);
        Session::put('cart',$cart);
        return redirect()->back();
    }
    public function getWelcome(){
        $cats=Post::get();
        $post=Poster::OrderBy('id','desc')->paginate(3);
        return view('welcome')->with(['cats'=>$cats,'post'=>$post]);
    }
    public function getImage($file_name){
       $file=Storage::disk('posts')->get($file_name);
       return response($file)->header('Content_type','*.*');
     }
    public function getPostByCategory($post_id){
        $cats=Post::get();
        $post=Poster::where('post_id',$post_id)-> OrderBy('id','desc')->paginate(3);
        return view('welcome')->with(['cats'=>$cats,'post'=>$post]);
        }
    public function  getSearchPost(Request $request)
    {   $q=$_GET['q'];
        $cats = Post::get();
        $post = Poster::where('item_name','LIKE',"%$q%")
            ->orwhere('price','LIKE',"%$q%")
            ->OrderBy('id', 'desc')->paginate(3);
        return view('welcome')->with(['cats' => $cats, 'post' => $post]);
    }
}
