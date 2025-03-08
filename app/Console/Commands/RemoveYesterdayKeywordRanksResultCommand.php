<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\RemoveYesterdayKeywordRanksResultJob;

class RemoveYesterdayKeywordRanksResultCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keywords:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Remove Data From Last Two Days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        RemoveYesterdayKeywordRanksResultJob::dispatch()->delay(now()->addSeconds(5));
    }
}
