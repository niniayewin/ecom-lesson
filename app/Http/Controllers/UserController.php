<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function getUsers(){
        $role=Role::get();
        $users=User::get();
        return view('users.all')->with(['role'=>$role,'users'=>$users]);
    }
    public function postAssignUserRole(Request $request){
        $user_id=$request['user_id'];
        $role=$request['role'];
        $user=User::whereId($user_id)->firstOrFail();
        $user->syncRoles($role);
        return redirect()->back()->with('info','The selected user role have been changed');
    }
    public function getDropPosts($id){
        $user=User::whereId($id)->firstOrFail();
        $user->delete();
        return redirect()->back()->with('info','the category have been delete');
    }
    public function postUpdatePosts(Request $request){
        $id=$request['id'];
        $user=User::whereId($id)->firstOrFail();
        $user->name=$request['name'];
        $user->email=$request['email'];
        $user->update();
        return redirect()->back()->with('info',"The selected have been updated");
    }

}
