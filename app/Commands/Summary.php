<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Summary extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'summary {--month : Month to show expense}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Summary of all expense or expense of specific month provided by --month';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $month = $this->option("month");
    }

}
