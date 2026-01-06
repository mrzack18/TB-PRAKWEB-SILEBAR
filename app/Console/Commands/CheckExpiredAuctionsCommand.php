<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckExpiredAuctions;

class CheckExpiredAuctionsCommand extends Command
{
    protected $signature = 'auctions:check-expired';
    protected $description = 'Check for expired auctions and process them';

    public function handle()
    {
        $this->info('Checking for expired auctions...');

        // Dispatch the job to check for expired auctions
        $job = new CheckExpiredAuctions();
        $job->handle();

        $this->info('Expired auction check completed.');
    }
}