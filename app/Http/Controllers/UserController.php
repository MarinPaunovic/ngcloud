<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $user = auth()->user();
        if($user->role === "admin"){
            $users = User::query('users')->where('role', '=', "user")->paginate(5);
            $files = DB::table('users')->join('files', "userId", "=", "users.id")->get();
           return summEachUserStorage($files,$users);
        }
         return redirect()->back()->withError("You dont have admin premission.");   
    }
}
