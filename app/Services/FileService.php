<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService{

    private $filePath = '/data/expense.csv';

    public function __construct()
    {
        $this->ensureFileExists();
    }

    public function doSomething(){
        echo "Doing Something\n";
    }

    private function ensureFileExists(){
        if(!Storage::exists(($this->filePath))){
            Storage::put($this->filePath,'ID,Date,Description,Amount');
        }
    }
}
