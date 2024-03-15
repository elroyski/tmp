<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DailyStatsController;

class SendStatsEmail extends Command
{
    protected $signature = 'send:stats-email {date?}';
    protected $description = 'Send daily and monthly sales stats via email.';

    public function handle()
    {
        $date = $this->argument('date'); // Opcjonalnie: pozwala na określenie daty
        $controller = new DailyStatsController();
        $controller->sendEmailWithStats($date);
        $this->info('The stats email has been sent successfully.');
    }
}
