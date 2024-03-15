<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\InventoryController;

class SendInventoryReport extends Command
{
    protected $signature = 'report:send-inventory';
    protected $description = 'Send inventory report to managers.';

    public function handle()
    {
        $controller = new InventoryController();
        $controller->emailReport(); 

        $this->info('Inventory report has been sent.');
    }
}
