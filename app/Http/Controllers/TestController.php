<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\TestMail;
use App\Models\Test;
use App\Mail\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('test');
         
    }

    public function reset(Request $request){

        $tokenExists=DB::table('password_resets')->where("email",$request->email)->first();
        if($tokenExists == null){
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => rand(100000,1000000),
                'created_at' => Carbon::now()
            ]);}
            
            $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();
        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
        } else {
            return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }
    }

    private function sendResetEmail($email, $token)
{
$user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
$link = Config::get('app')['url'] . '/password/reset/' . $token . '?email=' . urlencode($user->email);
if($link){
    Mail::to($email)->send(new TestMail($link));
    return true;
}
 return false;
}
}
