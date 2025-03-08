<?php

namespace App\Console\Commands;

use App\Models\Keyword;
use App\Jobs\SearchResultJob;
use Illuminate\Console\Command;

class SearchResultCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run search result job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Keyword::query()->chunk(100, function ($keywords) {
            foreach ($keywords as $keyword) {
                SearchResultJob::dispatch($keyword)->delay(now()->addSeconds());
            }
        });
    }
}
