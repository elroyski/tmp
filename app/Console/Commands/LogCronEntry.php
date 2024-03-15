<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LogCronEntry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logcronentry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

    \Log::info('Cron Entry from Command');
    }
        //

}
