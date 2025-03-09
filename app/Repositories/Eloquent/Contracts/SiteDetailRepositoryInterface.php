<?php

namespace App\Repositories\Eloquent\Contracts;

use Illuminate\Support\Collection;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface SiteDetailRepository
 * @package App\Repositories\Eloquent\Concretions
 */
interface SiteDetailRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get the progress of a specific keyword for a site within a date range.
     *
     * @param int $siteId
     * @param int $keywordId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getSiteKeywordProgress(int $siteId, int $keywordId, string $startDate, string $endDate): array;

    /**
     * Retrieve ranked site details for a given site within a date range.
     *
     * @param int $siteId
     * @param string $startDate
     * @param string $endDate
     * @param array $ranks
     * @param int $limit
     * @return Collection
     */
    public function getRankedSites(int $siteId, string $startDate, string $endDate, array $ranks, int $limit): Collection;

    /**
     * Retrieve the average ranking position per day for a given site and keywords.
     *
     * @param int $siteId
     * @param array|null $keywordIds
     * @param string $firstDate
     * @param string $lastDate
     * @return Collection
     */
    public function getAveragePosition(int $siteId, ?array $keywordIds, string $firstDate, string $lastDate): Collection;

    /**
     * Retrieve ranked site details along with keyword information.
     *
     * @param int $siteId
     * @return LengthAwarePaginator
     */
    public function analyzeKeywords(int $siteId): LengthAwarePaginator;

    /**
     * Retrieve the average ranking history for two competitor sites.
     *
     * @param array  $siteIds
     * @param string $startDate
     * @param string $endDate
     *
     * @return Collection
     */
    public function getAverageHistoryReportCompetitor(array $siteIds, string $startDate, string $endDate): Collection;

    /**
     * Retrieve the top-ranking competitor sites based on ranking criteria within a given date range.
     *
     * @param array $siteIds
     * @param array $ranks
     * @param string $startDate
     * @param string $endDate
     *
     * @return Collection
     */
    public function topSiteCompetitor(array $siteIds, array $ranks, string $startDate, string $endDate): Collection;

    /**
     * Retrieve the total search count per site within a given date range.
     *
     * @param array  $siteIds
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getSiteSearchVolume(array $siteIds, string $startDate, string $endDate): array;

    /**
     * Get keyword rank changes based on movement type.
     *
     * @param int $siteId
     * @param string $date
     * @param string $type
     * @return int
     */
    public function getKeywordRankChanges(int $siteId, string $date, string $type): int;
}
