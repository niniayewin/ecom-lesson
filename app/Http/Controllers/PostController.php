<?php

namespace App\Http\Controllers;
use Auth;
use App\Poster;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function postUpdatePost(Request $request){
        $id=$request['id'];
        $post=Poster::whereId($id)->firstOrFail();
        $image=$request->file('image');
        if($image){
            Storage::disk('posts')->delete($post->image);
            $img_name= $request['item_name'].'-'.date('dmyhis') .'.'.$request->file('image')->getClientOriginalExtension();
            $img=$request->file('image');
            Storage::disk('posts')->put($img_name,File::get($img));

            $post->image=$img_name;
        }
       $post->item_name=$request['item_name'];
        $post->price=$request['price'];
        $post->description=$request['description'];
        $post->post_id=$request['category'];
        $post->update();
        return redirect()->route('posts')->with('info',"The selected have been updated");
    }

    public function getEditPost($id){
        $cats=Post::get();
        $post=Poster::whereId($id)->firstOrFail();
        return view('Categories.edit-post')->with(['post'=>$post,'cats'=>$cats]);
    }
    public function getDropPost($id){
        $post=Poster::whereId($id)->firstOrFail();
        Storage::disk('posts')->delete($post->image);
        $post->delete();
        return redirect()->back()->with('info','the category have been delete');
    }

    public function getCategory(){
        $cats=Post::get();
        return view('Categories.categories')->with(['cats'=>$cats]);
    }
    public function NewCategories(Request $request){
        $this->validate($request,[
            "cat_name"=>"required|unique:posts"
        ]);
        $c=new Post();
        $c->cat_name=$request['cat_name'];
        $c->save();
        return redirect()->back()->with('info','The new post have been save');
    }
    public function DeleteCategories($id){
        $c=Post::whereId($id)->firstOrFail();
        $c->delete();
        return redirect()->back()->with('info','the category have been delete');
    }
    public function getUpdateCategory(Request $request){
        $cat_id=$request['cat_id'];
        $c=Post::whereId($cat_id)->firstOrFail();
        $c->cat_name=$request['cat_name'];
        $c->update();
        return redirect()->back()->with('info','the category have been updated');
    }

    public function getImage($file_name){
       $file=Storage::disk('posts')->get($file_name);
       return response($file)->header('Content-type','*.*');
    }

    public function getSearchPost(Request $request){
        $q=$request['q'];
        $posts=Poster::where('item_name',"LIKE","%$q%")
            ->orWhere('price',"LIKE","%$q%")
            ->paginate('3');
        return view('Categories.posts')->with(['posts'=>$posts]);
    }
    public function getPost(){
        $posts=Poster::OrderBy('id','desc')->paginate('3');
        return view('Categories.posts')->with(['posts'=>$posts]);
    }

    public function getNewPost(){
        $cats=Post::get();
        return  view('Categories.new')->with(['cats'=>$cats]);
    }
    public function postNewPost(Request $request){
        $this->validate($request,[
            'item_name'=>'required',
            'image'=>'required|mimes:jpg,jpeg,png,gif',
            'price'=>'required|numeric',
            'description'=>'required',
            'category'=>'required'
        ]);
        $image_name=$request['item_name'].'-'.date('dmyhis').'.'.$request->file('image')->getClientOriginalExtension();
        $image_file=$request->file('image');
        $ps=new Poster();
        $ps->item_name=$request['item_name'];
        $ps->image=$image_name;
        $ps->price=$request['price'];
        $ps->description=$request['description'];
        $ps->post_id=$request['category'];
        $ps->user_id=Auth::id();
        $ps->save();
        Storage::disk('posts')->put($image_name,File::get($image_file));

        return redirect()->back()->with('info','the  new post selected have been created');
    }

}
