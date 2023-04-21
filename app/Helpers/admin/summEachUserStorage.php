<?php
if (! function_exists('summEachUserStorage')) {
    function summEachUserStorage($files,$users) {
        $storageSize=[];
        foreach($users as $user){
            $userStorage=0;
            foreach($files as $file){
                if($file->userId == $user->id){
                    $userStorage = $userStorage + (float)$file->file_size;
                }
            };
            array_push($storageSize,[$user->id => $userStorage ]);
        };
        return view('users',["users"=>$users, 'sizes'=> $storageSize]);
    }
}