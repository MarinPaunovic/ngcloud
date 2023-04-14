<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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

    // public function store(Request $request){
    //     $request->validate([
    //         'photo' =>'required|image|mimes:jpg,jpeg,png,gif,csv,txt,xlx,xls,pdf|max:2048',
    //     ]);
    //     $photo = $request->file('photo')->store('public/uploads');
    //     $user = auth()->user()->id;
    //     $fileModel = new File;
    //     if($req->photo) {
    //         $fileName = time().'_'.$req->photo->getClientOriginalName();
    //         $filePath = $req->photo->storeAs('uploads', $fileName, 'public');
    //         $fileModel->userId = $user;
    //         $fileModel->name = time().'_'.$req->photo->getClientOriginalName();
    //         $fileModel->file_path = '/storage/' . $filePath;
    //         $fileModel->save();
    //     }
    //      return redirect()->back()->with('success','Photo uploaded successfully');
    // }
    

    public function upload(Request $request){        
        $request->validate([
            'photo' =>'required|image|mimes:jpg,jpeg,png,gif,csv,txt,xlx,xls,pdf|max:2048',
        ]);
        $photo = $request->file('photo')->store('public/uploads');
        
        $user = auth()->user()->id;
        $fileModel = new File;
        if($request->photo) {
            $fileName = time().'_'.$request->photo->hashName();
            $filePath = $request->photo;
            dd($fileName,$filePath);
            $fileModel->userId = $user;
            $fileModel->name = time().'_'.$request->photo->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
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
}
