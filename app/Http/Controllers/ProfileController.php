<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function update(User $user, Request $request){
        $request->validate([
            'email'=> 'required',
            'name'=> 'required'
        ]);

        $user = Auth::user();

        $user->email = $request->email;
        $user->name = $request->name;
        if($request['last-name']){
            $user->surname = $request['last-name'];
        }
        $user->save();


        return redirect()->back()->withSuccess('You have updated profile successfully!');
    }
}
