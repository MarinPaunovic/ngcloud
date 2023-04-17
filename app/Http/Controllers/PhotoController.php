<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\File;

class PhotoController extends Controller{
    
    public function create()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        return view('create');
    }

    public function upload(Request $request){ 
        $request->validate([
            'photo' =>'required|image|mimes:jpg,jpeg,png,gif,csv,txt,xlx,xls,pdf|max:2048',
        ]);
        $fileName=$request->photo->getClientOriginalName();

        $encryptedName = encrypt($request->photo->getClientOriginalName());

        $photo = $request->file('photo')->storeAs('public/uploads', $encryptedName);
        
        $user = auth()->user()->id;
        $fileModel = new File;
        if($request->photo) {
            $fileName = $encryptedName;
            $filePath = $request->photo;
            $fileModel->userId = $user;
            $fileModel->name = $encryptedName;
            $fileModel->file_path = '/storage/' . $fileName;
            $fileModel->save();
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
    }



    public function destroy($filename)
    {  
      if(Storage::disk('public')->exists($filename)){
          Storage::disk('public')->delete($filename);
          DB::table('files')->where('name', '=', $filename)->delete();
          return redirect()->back()->with('success','File deleted');
        return redirect()->back()->with('error','No file path');
      }
    } 

    public function download($filename){
        return response()->download(storage_path('/app/public/uploads/'.$filename), decrypt($filename));
    }

}