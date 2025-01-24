<?php

namespace App\Services;

use DateTime;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;

class FileService{

    private $filePath = '/data/expense.csv';

    public function __construct()
    {
        $this->ensureFileExists();
    }

    public function addData($description,$amount)
    {
        $currentFileLenght = count(explode("\n",Storage::get($this->filePath)));
        $time = new DateTime();
        $newData = [
            $currentFileLenght,
            $time->format('Y/m/d H:i:s'),
            $description,
            $amount
        ];
        if(Storage::append($this->filePath,implode(",",$newData))) return $currentFileLenght;
        return 0;
    }


    public function updateData($id,$description="",$amount=0){

    }

    public function deleteData($id){

    }

    public function listData(){

    }

    public function summaryData($month=0){
    }


    private function ensureFileExists(){
        if(!Storage::exists(($this->filePath))){
            Storage::put($this->filePath,'ID,Date,Description,Amount');
        }
    }
}
