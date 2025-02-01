<?php

namespace App\Services;

use DateTime;

use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;

class FileService{

    private $filePath = '/data/expense.csv';

    public function __construct()
    {
        $this->ensureFileExists();
    }

    public function addData($description,$amount)
    {
        $currentFileLenght = explode("\n",Storage::get($this->filePath));
        $latestID =explode(",",end($currentFileLenght))[0];
        $newID = (int)$latestID+1;
        $time = new DateTime();
        $newData = [
            $newID,
            $time->format('Y/m/d H:i:s'),
            $description,
            $amount
        ];
        if(Storage::append($this->filePath,implode(",",$newData))) return $newID;
        return 0;
    }


    public function updateData($id,$description,$amount){
        $updateStatus = 0;
        $data = explode("\n",Storage::get($this->filePath));

        // check data
        $updatedData = array_map(function($value) use($id,$description,$amount,&$updateStatus){
            $value = explode(",",$value);
            if($value[0]===$id && $value[0]!=="ID"){
                $updateStatus = $id;
                $time = new DateTime();
                $value[1] = $time->format('Y/m/d H:i:s');
                $value[2] = $description?:$value[2];
                $value[3] = $amount?:$value[3];
            }
            $value = implode(",",$value);
            return $value;
        },$data);

        if($updateStatus){
            Storage::put($this->filePath,implode("\n",$updatedData));
        }
        return $updateStatus;
    }

    public function deleteData($id){
        $deleteStatus = 0;
        $data = explode("\n",Storage::get($this->filePath));
        // exclude data with target id
        $updatedData = array_filter($data,function($value) use($id,&$deleteStatus){
            $value = explode(",",$value);
            $deleteValue = $id===$value[0];
            if($deleteValue && $value[0]!=="ID"){
                $deleteStatus = $id;
            }
            return !$deleteValue;
        });


        if($deleteStatus){
            $updatedData = implode("\n",$updatedData);
            // 不要な改行削除
            $updatedData = trim($updatedData,"\r");
            Storage::put($this->filePath,$updatedData);
        }
        return $deleteStatus;
    }

    public function listData(){
        $data = explode("\n",Storage::get($this->filePath));
        return $data;
    }

    public function summaryData($month=0){
        $now = new DateTime();
        $totalExpense = 0;

        // set current month if month is zero
        $month = (int)($month ?: $now->format('m'));
        $targetDate = $now->setDate($now->format('Y'),$month,1);
        $targetMonthName = $now->format('F');

        // excluding header
        $data = array_slice(
            explode("\n",Storage::get($this->filePath)),
            1
        );

        foreach($data as $expense){
            $expense = explode(",",$expense);
            $expenseDate = new DateTime($expense[1]);
            $expenseAmount = (int)end($expense);
            $expenseMonth = (int)$expenseDate->format("m");
            $totalExpense += ($expenseMonth === $month) ? $expenseAmount : 0;
        }

        return [$targetMonthName,$totalExpense];

    }


    private function ensureFileExists(){
        if(!Storage::exists(($this->filePath))){
            Storage::put($this->filePath,'ID,Date,Description,Amount');
        }
    }
}
