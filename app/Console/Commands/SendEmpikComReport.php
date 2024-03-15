<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DailyStatsController;

class sendEmpikComReport extends Command
{
    protected $signature = 'send:empikcom-report {date?}';
    protected $description = 'Send Empik.com sales report for managers with store_id=70401.';

    public function handle()
    {
        $date = $this->argument('date');
        $controller = new DailyStatsController();
        $controller->sendEmpikComReport($date);
        $this->info('The Empik.com report has been sent to managers successfully.');
    }
}
