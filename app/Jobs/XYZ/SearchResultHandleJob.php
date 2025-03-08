<?php

namespace App\Jobs\XYZ;

use App\Models\TempKeyword;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\RequestException;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Foundation\Bus\PendingClosureDispatch;

class SearchResultHandleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TempKeyword $keyword
     */
    protected TempKeyword $keyword;

    /**
     * Create a new job instance.
     * @param TempKeyword $keyword
     */
    public function __construct(TempKeyword $keyword)
    {
        $this->onQueue('search_result_xyz_queue');

        $this->keyword = $keyword;
    }


    /**
     * @return void
     * @throws RequestException
     */
    public function handle(): void
    {
        $payload    = [
            'q'     => $this->keyword->title,
            'gl'    => 'ir',
            'hl'    => 'fa',
            'num'   => '100',
            'page'  => '1'
        ];

        $response   = Http::withHeaders([
            'X-API-KEY'     => config('services.google.api_key'),
            'Content-Type'  => 'application/json',
        ])->post('https://google.serper.dev/search', $payload);

        if ($response->status() == 400) {
            logger()->error('Not enough credits in serper api!');

            return;
        }

        $response->throw();

        SearchResultHandleChildJob::dispatch($response->json()['organic'], $this->keyword);
    }

    /**
     * @param \Throwable $exception
     * @return PendingClosureDispatch|PendingDispatch
     */
    public function failed(\Throwable $exception)
    {
        report($exception);

        logger()->error('search result failed process!', ['keyword_id' => $this->keyword->id]);

        return dispatch($this)->delay(5);
    }
}
