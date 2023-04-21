<?php
use App\Models\User;

if (! function_exists('summAllUserStorage')) {
    function summAllUserStorage($files) {
        $users = User::all();
        $totalStorage=0;
        $totalUsedStorage=0;
        $userCount=0;
        foreach($users as $user){
            $userCount++;
            $totalStorage= $totalStorage + 3000;
            foreach($files as $file){
                $totalUsedStorage = $totalUsedStorage + (float)$file->file_size;
            }
        }
    
        $totalUsedStorageMB= convertBytesToMB($totalUsedStorage); 
        $availableStorage= (($totalStorage - $totalUsedStorageMB) / 1000);
        $finalAvailableStorage = (float)number_format(floor($availableStorage*100)/100, 2);
        $finalTotalStorage= $totalStorage/1000;
        return ['used'=>$finalAvailableStorage,'total'=>$finalTotalStorage,'userCount'=>$userCount];
    }
}