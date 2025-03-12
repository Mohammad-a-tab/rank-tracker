<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\KeywordRanks;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveYesterdayKeywordRanksResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('remove_keywords_ranks_queue');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $twoDaysAgo = Carbon::now()->subDays(2)->endOfDay();

        KeywordRanks::query()
            ->where('created_at', '<=' , $twoDaysAgo)
            ->delete();
    }

    public function failed(\Throwable $exception)
    {
        report($exception);
        logger()->error('Keywords Ranks removed Has Failed');

        return dispatch($this)->delay(5);
    }
}
