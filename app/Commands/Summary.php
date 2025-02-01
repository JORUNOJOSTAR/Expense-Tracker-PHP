<?php

namespace App\Commands;

use App\Services\FileService;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use DateTime;
class Summary extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'summary {--month= : Month to show expense}';
    protected $fileService;
    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Summary of all expense or expense of specific month provided by --month';

    public function __construct(FileService $fileService)
    {
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
        $inputMonth = $this->option("month");
        $targetMonth = isset($inputMonth) ? $this->inputChecker($inputMonth) : 0;
        $totalExpense = $this->fileService->summaryData($targetMonth);
        $this->info("Total expense for is {$totalExpense[0]} is {$totalExpense[1]}");
    }

    private function inputChecker($month){
        if($month<=0 or $month>12){
            $this->error("Invalid month");
           exit(1);
        }
        return $month;
    }

}
