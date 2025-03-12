<?php

namespace App\Repositories\Eloquent\Concretions;

use App\Models\KeywordRanks;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\keyword\RankKeywordResource;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Eloquent\Contracts\KeywordRanksRepositoryInterface;

class KeywordRanksRepository extends EloquentBaseRepository implements KeywordRanksRepositoryInterface
{
    public function model(): string
    {
        return KeywordRanks::class;
    }

    /**
     * @inheritDoc
     */
    public function getCompetitorsTopSitesToday(array $ranks): array
    {
        return $this->model->query()
            ->select('site_id', 'latest_rank', 'keyword_id')
            ->whereBetween('latest_rank', $ranks)
            ->with('sites')
            ->orderBy('latest_rank', 'desc')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getCompetitorsAverageMapToday(array $keywordIds): Collection
    {
        return $this->model->query()
            ->select('site_id', DB::raw('AVG(latest_rank) as average_rank'))
            ->whereIn('keyword_id', $keywordIds)
            ->with([
                'sites:id,url'
            ])
            ->groupBy('site_id')
            ->orderByDesc('average_rank')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getRankStatistics(int $siteId, int $keywords): array
    {
        $rankChanges = $this->model->rankChanges($siteId)->with('keyword')->get();

        $increasedRanks = $rankChanges->where('rank_change', '>', 0);
        $increasedRanksArray = RankKeywordResource::collection($increasedRanks)->values()->toArray();
        $increasedRanksCount = $increasedRanks->count();

        $decreasedRanks = $rankChanges->where('rank_change', '<', 0);
        $decreasedRanksArray = RankKeywordResource::collection($decreasedRanks)->values()->toArray();
        $decreasedRanksCount = $decreasedRanks->count();

        $topOneCount = $this->model->where('site_id', $siteId)->where('latest_rank', 1)->count();
        $topThreeCount = $this->model->where('site_id', $siteId)->whereBetween('latest_rank', [2, 3])->count();
        $topTenCount = $this->model->where('site_id', $siteId)->whereBetween('latest_rank', [4, 10])->count();
        $noRankCount = $this->model->where('site_id', $siteId)->whereNotBetween('latest_rank', [1, 10])->count();

        $topOnePercentage = round(($topOneCount / $keywords) * 100, 2);
        $topThreePercentage = round(($topThreeCount / $keywords) * 100, 2);
        $topTenPercentage = round(($topTenCount / $keywords) * 100, 2);
        $noRankPercentage = round(($noRankCount / $keywords) * 100, 2);

        return [
            'increased_ranks' => [
                'data' => $increasedRanksArray,
                'count' => $increasedRanksCount,
            ],
            'decreased_ranks' => [
                'data' => $decreasedRanksArray,
                'count' => $decreasedRanksCount,
            ],
            'top_one' => [
                'count' => $topOneCount,
                'percentage' => $topOnePercentage,
            ],
            'top_three' => [
                'count' => $topThreeCount,
                'percentage' => $topThreePercentage,
            ],
            'top_ten' => [
                'count' => $topTenCount,
                'percentage' => $topTenPercentage,
            ],
            'no_rank' => [
                'count' => $noRankCount,
                'percentage' => $noRankPercentage,
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getLosersWinners(int $limit): array
    {
        $rankChanges = $this->model->withRankChanges()->get();

        return [
            'winners' => $rankChanges->sortByDesc('rank_change')->take($limit)->values()->toArray(),
            'losers'  => $rankChanges->sortBy('rank_change')->take($limit)->values()->toArray(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getRankChangesByType(int $siteId, string $type): Collection
    {
        $rankChanges = $this->model->rankChanges($siteId)->get();

        return $rankChanges->filter(function ($rank) use ($type) {
            return $type === 'decreased' ? $rank->rank_change < 0 : $rank->rank_change > 0;
        });
    }
}
