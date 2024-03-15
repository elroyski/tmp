<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Services\ElibriApiService;

class RefillQueueCommand extends Command {
    protected $signature = 'elibri:refill-queue';
    protected $description = 'Refill the Elibri queue with all books';

    private $elibriService;

    public function __construct(ElibriApiService $elibriService) {
        parent::__construct();
        $this->elibriService = $elibriService;
    }

    public function handle() {
        $this->elibriService->refillQueue();
        $this->info('Queue refilled with all books.');
    }
}
