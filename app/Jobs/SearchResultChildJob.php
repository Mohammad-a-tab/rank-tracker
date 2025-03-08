<?php

namespace App\Jobs;

use App\Models\Site;
use App\Models\Keyword;
use App\Models\SiteDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchResultChildJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array $data
     */
    protected array $data;

    /**
     * @var Keyword $keyword
     */
    protected Keyword $keyword;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data, Keyword $keyword)
    {
        $this->data     = $data;
        $this->keyword  = $keyword;

        $this->onQueue('search_result_child_queue');
    }

    /**
     * Execute the job.
     * @throws \Throwable
     */
    public function handle(): void
    {
            $data = [];
            foreach ($this->data as $item) {
                $baseUrl = parse_url($item['link'])['host'];

                if (!isset($data[$baseUrl])) {
                    $data[$baseUrl] = $item;
                }
        }

        $result = [];
        foreach ($data as $url => $item) {
            $site = Site::query()->where('url', $url)->first();

            if ($site) {
                $siteDetail = SiteDetail::query()
                    ->where('site_id', $site->id)
                    ->where('keyword_id', $this->keyword->id)
                    ->orderByDesc('id')
                    ->first();

                $result[] = [
                    'site_id'           => $site->id,
                    'keyword_id'        => $this->keyword->id,
                    'title'             => $item['title'],
                    'rank'              => $item['position'],
                    'yesterday_rank'    => $siteDetail?->rank,
                    'link'              => $item['link'],
                    'created_at'        => now()->format('Y-m-d H:i:s'),
                    'updated_at'        => now()->format('Y-m-d H:i:s'),
                ];
            }
        }

        try {
            DB::beginTransaction();

            SiteDetail::query()->insert($result);
//             This is Commented because we have decided to use this filed in an other way
//            $this->keyword->update(['search_count' => $this->keyword->search_count + 1]);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function failed(\Throwable $exception)
    {
        report($exception);
        logger()->error('error in search result child job!', ['exception' => $exception, 'keyword_id' => $this->keyword->id]);

        return dispatch($this)->delay(5);
    }
}
