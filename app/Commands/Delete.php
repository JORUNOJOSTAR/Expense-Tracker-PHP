<?php

namespace App\Commands;

use App\Services\FileService;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Delete extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'delete {--id= : ID of target expense}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Delete an expense';
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
        $id = $this->option("id");
        if(!$id){
            $this->error("ID is missing for expense to be updated\n");
            return 1;
        }

        if($this->fileService->deleteData($id)){
            $this->info("Expense deleted successfully (ID: {$id})");
        }else{
            $this->error("Expense not found (ID: {$id})");
        };
    }

}
