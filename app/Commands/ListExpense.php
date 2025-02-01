<?php

namespace App\Commands;


use LaravelZero\Framework\Commands\Command;
use App\Services\FileService;
class ListExpense extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'listexp';
    protected $fileService;
    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'View all expense';

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
        $fileData = $this->fileService->listData();
        $this->info("Listing Up all data");
        foreach($fileData as $data){
            $data = str_replace(",","  |  ",$data);
            $this->info($data);
        }
    }

}
