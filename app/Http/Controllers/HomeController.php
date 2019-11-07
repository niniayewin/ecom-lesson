<?php

namespace App\Http\Controllers;
use App\Orders;
use App\Post;
use App\Poster;
use App\User;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::User()->hasAnyRole(['Member'])){
            $orders=Orders::where('user_id',Auth::id())->get();
            return view('home')->with(['orders'=>$orders]);
        }elseif (Auth::User()->hasAnyRole(['Admin'])){
            $orders=Orders::get();
            $cats=Post::get();
            $post=Poster::get();
            $users=User::get();
            return view('home')->with(['orders'=>$orders,
                           'cats'=>$cats,
                            'post'=>$post,
                            'users'=>$users]);
        }else{
            return redirect()->route('/');
        }

    }
}
