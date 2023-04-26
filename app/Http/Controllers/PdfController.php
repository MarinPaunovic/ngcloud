<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    public function index(){
        $users = User::all();
        return view('pdf', compact('users'));
    }

    public function createPDF(Request $request){
        $data=[];
        $test=[];
        $checkboxes=$request->except('_token');


        foreach ($checkboxes as $key=>$value) {
            $str = explode("checkbox",$key);
            $userId = (int)$str[1];
            array_push($test,$userId);
            $user = User::where('id', $userId)->first();
            array_push($data, $user);
        }
        view()->share('users', $data);
        $pdf = PDF::loadView('pdfDownload', $data);
        return $pdf->download("file-name.pdf");
    }
}
