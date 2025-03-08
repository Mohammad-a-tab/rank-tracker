<?php

namespace App\Jobs\XYZ;

use App\Models\TempKeyword;
use App\Models\SearchResult;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchResultHandleChildJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array $data
     */
    protected array $data;

    /**
     * @var TempKeyword $keyword
     */
    protected TempKeyword $keyword;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data, TempKeyword $keyword)
    {
        $this->data     = $data;
        $this->keyword  = $keyword;

        $this->onQueue('search_result_insert_xyz_queue');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = [];

        foreach ($this->data as $item) {
            preg_match('/^(https?:\/\/)([^\/]+)(\/.*)?$/', $item['link'], $matches);

            $url    = (count($matches) >= 2) ? $matches[2] : null;

            // generating data
            $data[] = [
                'keyword_id'            => $this->keyword->id,
                'external_keyword_id'   => $this->keyword->external_keyword_id,
                'title'                 => $item['title']       ?? null,
                'url'                   => $url,
                'full_url'              => $item['link'],
                'description'           => $item['snippet']     ?? null,
                'rank'                  => $item['position']    ?? null,
                'created_at'            => now()->format('Y-m-d H:i:s'),
                'updated_at'            => now()->format('Y-m-d H:i:s')
            ];
        }

        SearchResult::query()->insert($data);
    }

    public function failed(\Throwable $exception)
    {
        report($exception);
        logger()->error('error in search result handle child job!', ['exception' => $exception, 'keyword_id' => $this->keyword->id]);

        return dispatch($this)->delay(5);
    }
}
