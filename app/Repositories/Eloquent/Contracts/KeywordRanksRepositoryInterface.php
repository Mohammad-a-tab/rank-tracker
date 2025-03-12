<?php

namespace App\Repositories\Eloquent\Contracts;

use Illuminate\Support\Collection;
use App\Repositories\BaseRepositoryInterface;

/**
 * Interface KeywordRanksRepository
 * @package App\Repositories\Eloquent\Concretions
 */
interface KeywordRanksRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get the top sites ranking map for competitors' keywords today.
     *
     * @param array $ranks
     * @return array
     */
    public function getCompetitorsTopSitesToday(array $ranks): array;

    /**
     * Get the average ranking map for competitors keywords today.
     *
     * @param array $keywordIds
     * @return Collection
     */
    public function getCompetitorsAverageMapToday(array $keywordIds): Collection;

    /**
     * @param int $siteId
     * @param int $keywords
     * @return array
     */
    public function getRankStatistics(int $siteId, int $keywords): array;

    /**
     * Get losers and winners sites with rank changes.
     *
     * @param int $limit
     * @return array
     */
    public function getLosersWinners(int $limit): array;

    /**
     * Get rank changes for a given site based on type.
     *
     * @param int $siteId
     * @param string $type
     * @return Collection
     */
    public function getRankChangesByType(int $siteId, string $type): Collection;
}
