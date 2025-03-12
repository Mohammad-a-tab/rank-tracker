<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\KeywordRanks;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;


class InsertKeywordsRanksChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $timeout = 300;
    public int $tries = 3;

    protected array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->onQueue('insert_keywords_ranks_child_queue');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();

            $chunks = array_chunk($this->data,1000);

            foreach($chunks as $chunk){
                KeywordRanks::insert($chunk);
            }
//            foreach ($this->data as $item) {
//                KeywordsRanks::insert(
//                    [
//                        'keyword_id'     => $item['keyword_id'],
//                        'site_id'        => $item['site_id'],
//                        'latest_rank'    => $item['latest_rank'],
//                        'first_rank'     => $item['first_rank'],
//                        'created_at'     => $item['created_at'],
//                        'updated_at'     => $item['updated_at'],
//                        'site_detail_id' => $item['site_detail_id']
//                    ]
//                );
//            }
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function failed(\Throwable $exception){
        if( $this->attempts() > 2){
            logger()->error('Keywords Rank Chunk Insertion Failed After 2 Times : '.$exception->getMessage());
            return;
        }

        logger()->error('Keywords Rank Chunk Insertion Has Failed : '.$exception->getMessage());
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
