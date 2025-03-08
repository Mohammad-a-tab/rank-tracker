<?php

namespace App\Console\Commands;

use App\Jobs\InsertKeywordsRankJob;
use Illuminate\Console\Command;

class DispatchKeywordsRankCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keywords:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run InsertKeywordsRank Job for creating KeywordsRank';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        InsertKeywordsRankJob::dispatch()->delay(now()->addSeconds(10));
    }
}
