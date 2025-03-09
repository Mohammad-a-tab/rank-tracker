<?php

namespace App\Repositories\Eloquent\Concretions;

use App\Models\Keyword;
use Illuminate\Support\Collection;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Eloquent\Contracts\KeywordRepositoryInterface;

class KeywordRepository extends EloquentBaseRepository implements KeywordRepositoryInterface
{
    public function model(): string
    {
        return Keyword::class;
    }


    /**
     * @inheritDoc
     */
    public function getAllKeywords(): Collection
    {
        return $this->model->query()->select(['id', 'name'])->get();
    }

    /**
     * @inheritDoc
     */
    public function getCompetitorsSearchVolumeRanking(int $offset, int $perPage): Collection
    {
        return $this->model->newQuery()
            ->select(['id', 'keyword_url', 'name', 'keyword_volume'])
            ->orderBy('id')
            ->skip($offset)
            ->take($perPage)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getCompetitorsTopOneMapToday(): array
    {
        // TODO: Implement getCompetitorsTopOneMapToday() method.
    }

    /**
     * @inheritDoc
     */
    public function getCompetitorsTopThreeMapToday(): array
    {
        // TODO: Implement getCompetitorsTopThreeMapToday() method.
    }

    /**
     * @inheritDoc
     */
    public function getCompetitorsTopTenMapToday(): array
    {
        // TODO: Implement getCompetitorsTopTenMapToday() method.
    }

    /**
     * @inheritDoc
     */
    public function getCompetitorsAverageMapToday(array $keywords): Collection
    {
        // TODO: Implement getCompetitorsAverageMapToday() method.
    }

    /**
     * @inheritDoc
     */
    public function analyzeKeywords(): Collection
    {
        // TODO: Implement analyzeKeywords() method.
    }

    /**
     * @inheritDoc
     */
    public function getKeywordPositionDistribution(int $siteId): array
    {
        // TODO: Implement getKeywordPositionDistribution() method.
    }

    /**
     * @inheritDoc
     */
    public function getAverageHistoryReportCompetitor(int $siteId, string $startDate, string $endDate): array
    {
        // TODO: Implement getAverageHistoryReportCompetitor() method.
    }

    /**
     * @inheritDoc
     */
    public function getTopOneMapCompetitor(int $siteId, string $startDate, string $endDate): array
    {
        // TODO: Implement getTopOneMapCompetitor() method.
    }

    /**
     * @inheritDoc
     */
    public function getTopThreeMapCompetitor(int $siteId, string $startDate, string $endDate): array
    {
        // TODO: Implement getTopThreeMapCompetitor() method.
    }

    /**
     * @inheritDoc
     */
    public function getTopTenMapCompetitor(int $siteId, string $startDate, string $endDate): array
    {
        // TODO: Implement getTopTenMapCompetitor() method.
    }

    /**
     * @inheritDoc
     */
    public function getCompetitorsSearchVolumeRankingWithSite(int $siteId, string $startDate, string $endDate): array
    {
        // TODO: Implement getCompetitorsSearchVolumeRankingWithSite() method.
    }

    /**
     * @inheritDoc
     */
    public function getLosersWinners(int $limit): array
    {
        // TODO: Implement getLosersWinners() method.
    }

    /**
     * @inheritDoc
     */
    public function analyzeKeywordsCompetitor(int $siteId): array
    {
        // TODO: Implement analyzeKeywordsCompetitor() method.
    }

    /**
     * @inheritDoc
     */
    public function getGainersLosersDecreased(int $siteId): array
    {
        // TODO: Implement getGainersLosersDecreased() method.
    }

    /**
     * @inheritDoc
     */
    public function getGainersLosersIncreased(int $siteId): array
    {
        // TODO: Implement getGainersLosersIncreased() method.
    }

    /**
     * @inheritDoc
     */
    public function getKeywordPositionFlow(): array
    {
        // TODO: Implement getKeywordPositionFlow() method.
    }
}
