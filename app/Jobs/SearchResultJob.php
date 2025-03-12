<?php

namespace App\Jobs;

use App\Models\Keyword;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Foundation\Bus\PendingClosureDispatch;

class SearchResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected Keyword $keyword;

    public function __construct(Keyword $keyword)
    {
        $this->keyword = $keyword;

        $this->onQueue('search_result_queue');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $payload = [
            'q'     => $this->keyword->name,
            'gl'    => 'ir',
            'hl'    => 'fa',
            'num'   => '100',
            'page'  => '1'
        ];

        $response = Http::withHeaders([
            'X-API-KEY'     => config('services.google.api_key'),
            'Content-Type'  => 'application/json',
        ])->post(config('services.google.api_key'), $payload);

        if ($response->status() == 400) {
            logger()->error('Not enough credits in serper api!');

            return;
        }

        $response->throw();

        SearchResultChildJob::dispatch($response->json()['organic'], $this->keyword);
    }

    /**
     * @param \Throwable $exception
     * @return PendingClosureDispatch|PendingDispatch
     */
    public function failed(\Throwable $exception)
    {
        logger()->error('error in search result job!', ['exception' => $exception, 'keyword_id' => $this->keyword->id]);

        return dispatch($this)->delay(5);
    }
}
