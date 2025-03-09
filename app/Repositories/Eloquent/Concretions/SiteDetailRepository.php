<?php

namespace App\Repositories\Eloquent\Concretions;

use App\Models\SiteDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Eloquent\Contracts\SiteDetailRepositoryInterface;

class SiteDetailRepository extends EloquentBaseRepository implements SiteDetailRepositoryInterface
{
    public function model(): string
    {
        return SiteDetail::class;
    }

    /**
     * @inheritDoc
     */
    public function getSiteKeywordProgress(int $siteId, int $keywordId, string $startDate, string $endDate): array
    {
        return $this->model->query()
            ->where('site_id', $siteId)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->whereHas('keyword', function ($query) use ($keywordId) {
                $query->where('id', $keywordId);
            })
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getRankedSites(int $siteId, string $startDate, string $endDate, array $ranks, int $limit): Collection
    {
        return $this->model->query()
            ->selectRaw('COUNT(rank) AS total_sites, rank, keyword_id')
            ->with('keyword:id,name')
            ->where('site_id', $siteId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereBetween('rank', $ranks)
            ->groupBy('keyword_id', 'rank')
            ->orderBy('rank', 'asc')
            ->limit($limit ?? 50)
            ->get()
            ->map(function ($site) {
                $site->keyword = $site->keyword->name ?? null;
                return $site;
            });
    }

    /**
     * @inheritDoc
     */
    public function getAveragePosition(int $siteId, ?array $keywordIds, string $firstDate, string $lastDate): Collection
    {
        return $this->model->query()
            ->selectRaw('DATE(created_at) as created_date, AVG(`rank`) as average_rank')
            ->where('site_id', $siteId)
            ->whereBetween('created_at', [$firstDate, $lastDate])
            ->when($keywordIds, function (Builder $query) use ($keywordIds) {
                $query->whereIn('keyword_id', $keywordIds);
            })
            ->groupByRaw('DATE(created_at)')
            ->pluck('average_rank', 'created_date');
    }

    /**
     * @inheritDoc
     */
    public function analyzeKeywords(int $siteId): LengthAwarePaginator
    {
        return $this->model->query()
            ->select([
                'site_details.rank',
                'site_details.link',
                'keywords.name as keyword',
                'keywords.keyword_volume as search_volume'
            ])
            ->join('keywords', 'site_details.keyword_id', '=', 'keywords.id')
            ->where('site_details.site_id', $siteId)
            ->orderBy('site_details.rank', 'ASC')
            ->paginate(10);
    }

    /**
     * @inheritDoc
     */
    public function getAverageHistoryReportCompetitor(array $siteIds, string $startDate, string $endDate): Collection
    {
        return $this->model->query()
            ->selectRaw('site_id, DATE(created_at) as created_date, AVG(`rank`) as average_rank')
            ->whereIn('site_id', $siteIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('site_id', DB::raw('DATE(created_at)'))
            ->orderBy('created_date', 'ASC')
            ->get()
            ->groupBy('site_id');
    }

    /**
     * @inheritDoc
     */
    public function topSiteCompetitor(array $siteIds, array $ranks, string $startDate, string $endDate): Collection
    {
        return $this->model->query()
            ->selectRaw('AVG(`rank`) as average_rank, site_id, DATE(created_at) as date')
            ->whereIn('site_id', $siteIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereBetween('rank', $ranks)
            ->groupBy('site_id', DB::raw('DATE(created_at)'))
            ->orderBy('date', 'ASC')
            ->get()
            ->groupBy('site_id');
    }

    /**
     * @inheritDoc
     */
    public function getSiteSearchVolume(array $siteIds, string $startDate, string $endDate): array
    {
        return $this->model->query()
            ->select([
                'sites.url',
                DB::raw('DATE(site_details.created_at) as date'),
                DB::raw('SUM(keywords.keyword_volume) as total_search_count'),
            ])
            ->join('keywords', 'keywords.id', '=', 'site_details.keyword_id')
            ->join('sites', 'sites.id', '=', 'site_details.site_id')
            ->whereIn('site_details.site_id', $siteIds)
            ->whereBetween('site_details.created_at', [$startDate, $endDate])
            ->groupBy('sites.url', DB::raw('DATE(site_details.created_at)'))
            ->orderBy('sites.url')
            ->orderBy('date')
            ->get()
            ->groupBy('url')
            ->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getKeywordRankChanges(int $siteId, string $date, string $type): int
    {
        $query = $this->model->query()
            ->select('site_details.keyword_id', 'site_details.rank', 'site_details.yesterday_rank')
            ->where('site_details.site_id', '=', $siteId)
            ->whereBetween('site_details.created_at', ["{$date} 00:00:00", "{$date} 23:59:59"]);

        match ($type) {
            'up'        => $query->whereRaw('`rank` < yesterday_rank'),
            'down'      => $query->whereRaw('`rank` > yesterday_rank'),
            'unchanged' => $query->whereRaw('`rank` = yesterday_rank'),
        };

        return $query->distinct()->count('site_details.keyword_id');
    }
}
