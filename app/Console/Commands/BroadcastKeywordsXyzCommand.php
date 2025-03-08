<?php

namespace App\Console\Commands;

use App\Models\TempKeyword;
use Illuminate\Console\Command;
use App\Jobs\XYZ\SearchResultHandleJob;

class BroadcastKeywordsXyzCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:keywords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data in temp keyword table with chunk for dispatched job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('starting broadcast keywords...');

        TempKeyword::query()->chunk(1000, function ($keywords) {
            foreach ($keywords as $keyword) {
                SearchResultHandleJob::dispatch($keyword);
            }
        });

        $this->info('keywords broadcasted successfully!');
    }
}
