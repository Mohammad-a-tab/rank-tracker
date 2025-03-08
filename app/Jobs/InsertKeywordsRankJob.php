<?php

namespace App\Jobs;

use App\Models\SiteDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class InsertKeywordsRankJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('insert_keywords_ranks_queue');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $startOfDay = Carbon::now()->startOfDay();
        SiteDetail::query()->where('created_at', '>=', $startOfDay)
            ->chunk(1000, function ($siteDetails) {
                $data = [];

                foreach ($siteDetails as $siteDetail) {

                    $data[] = [
                        'site_detail_id'    => $siteDetail->id,
                        'keyword_id'        => $siteDetail->keyword_id,
                        'site_id'           => $siteDetail->site_id,
                        'latest_rank'       => $siteDetail->rank,
                        'first_rank'        => $siteDetail->yesterday_rank,
                        'created_at'        => now()->format('Y-m-d H:i:s'),
                        'updated_at'        => now()->format('Y-m-d H:i:s')
                    ];
                }

                InsertKeywordsRanksChunkJob::dispatch($data);
            });
    }

    public function failed(\Throwable $exception)
    {
        report($exception);
        logger()->error('Keywords Ranks Insertion Has Failed: '.$exception->getMessage());
    }

    /**
     * Specify the backoff time for retries.
     *
     * @return array
     */
    public function backoff()
    {
        return [60, 120, 300];
    }
}
