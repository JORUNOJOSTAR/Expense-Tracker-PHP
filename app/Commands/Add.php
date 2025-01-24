<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use App\Services\FileService;

class Add extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'add {--description= : desription of expense} {--amount= : cost of expense} ';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Add an expense with a description and amount';
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
        $description = $this->option('description');
        $amount = $this->option('amount');
        if(!$description or !$amount){
            $description?:$this->error("Description for expense is missing");
            $amount?:$this->error("Amount for expense is missing");
            return 1;
        }
        $newID = $this->fileService->addData($description,$amount);
        if($newID){
            $this->info("Expense added successfully (ID: {$newID})");
        }else{
            $this->error("Fail to add new expense");
        };
    }


}
