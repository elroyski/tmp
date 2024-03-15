<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Services\ElibriApiService;

class GetPublishersCommand extends Command {
    protected $signature = 'elibri:get-publishers';
    protected $description = 'Get list of publishers from Elibri API';

    private $elibriService;

    public function __construct(ElibriApiService $elibriService) {
        parent::__construct();
        $this->elibriService = $elibriService;
    }

    public function handle() {
        $publishers = $this->elibriService->getPublishers();
        $this->info('Publishers:');
        print_r($publishers);
    }
}
