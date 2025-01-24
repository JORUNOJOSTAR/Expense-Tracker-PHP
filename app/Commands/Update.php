<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Update extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'update
                                {--id= : ID of target expense}
                                {--description : desription of expense}
                                {--amount : cost of expense}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Update description or cost of an expense';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }

}
