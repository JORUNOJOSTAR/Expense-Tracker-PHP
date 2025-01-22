<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $description = $this->option('description');
        $amount = $this->option('amount');
    }

}
