<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Services\FileService;

class Update extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'update {--id= : ID of expense} {--description= : desription of expense} {--amount= : cost of expense} ';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Update description or cost of an expense';
    protected $fileService;

    public function __construct(FileService $fileService){
        parent::__construct();
        $this->fileService = $fileService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $targetID = $this->option('id');
        $description = $this->option('description');
        $amount = $this->option('amount');

        $this->inputChecker($targetID,$description,$amount);

        $updateStatus = $this->fileService->updateData($targetID,$description,$amount);


        if($updateStatus){
            $this->info("Expense updated successfully (ID: {$targetID})");
        }else{
            $this->error("Expense not found (ID: {$targetID})");
        }
    }

    private function inputChecker($targetID,$description,$amount){
        $errMsg = "";
        $errMsg .= $targetID?"":"ID is missing for expense to be updated\n";
        $errMsg .= ($description or $amount)?"":"Description or amount of expense is missing";

        if($errMsg){
            $this->error($errMsg);
            exit(1);
        }
    }

}
