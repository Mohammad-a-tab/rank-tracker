<?php

namespace App\Repositories\Eloquent\Contracts;

use Illuminate\Support\Collection;
use App\Repositories\BaseRepositoryInterface;

/**
 * Interface KeywordRepository
 * @package App\Repositories\Eloquent\Concretions
 */
interface KeywordRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all keywords with their IDs and names.
     *
     * @return Collection
     */
    public function getAllKeywords(): Collection;

    /**
     * Get the progress of a specific keyword for a site within a date range.
     *
     * @param int $siteId
     * @param int $keywordId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getKeywordProgress(int $siteId, int $keywordId, string $startDate, string $endDate): array;

    /**
     * Get the top 3 rankings for keywords of a site within a date range.
     *
     * @param int $siteId
     * @param string $startDate
     * @param string $endDate
     * @param int $limit
     * @return Collection
     */
    public function getKeywordTop3(int $siteId, string $startDate, string $endDate, int $limit): Collection;

    /**
     * Get the top 10 rankings for keywords of a site within a date range.
     *
     * @param int $siteId
     * @param string $startDate
     * @param string $endDate
     * @param int $limit
     * @return Collection
     */
    public function getKeywordTop10(int $siteId, string $startDate, string $endDate, int $limit): Collection;

    /**
     * Import keywords from a file or data source.
     *
     * @param array $data
     * @return void
     */
    public function importKeywords(array $data): void;

    /**
     * Get the average position of keywords for multiple sites within a date range.
     *
     * @param array $siteIds
     * @param array $keywordIds
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getAveragePosition(array $siteIds, array $keywordIds, string $startDate, string $endDate): array;

    /**
     * Get paginated keywords with specific fields.
     *
     * @param int $offset
     * @param int $perPage
     * @return Collection
     */
    public function getCompetitorsSearchVolumeRanking(int $offset, int $perPage): Collection;



    /**
     * Analyze keywords for a specific site.
     *
     * @return Collection
     */
    public function analyzeKeywords(): Collection;

    /**
     * Get the position distribution of keywords for a site.
     *
     * @param int $siteId
     * @return array
     */
    public function getKeywordPositionDistribution(int $siteId): array;

    /**
     * Get the average history report for a competitor's keywords.
     *
     * @param int $siteId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getAverageHistoryReportCompetitor(int $siteId, string $startDate, string $endDate): array;

    /**
     * Get the top 1 ranking map for a competitor's keywords within a date range.
     *
     * @param int $siteId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getTopOneMapCompetitor(int $siteId, string $startDate, string $endDate): array;

    /**
     * Get the top 3 ranking map for a competitor's keywords within a date range.
     *
     * @param int $siteId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getTopThreeMapCompetitor(int $siteId, string $startDate, string $endDate): array;

    /**
     * Get the top 10 ranking map for a competitor's keywords within a date range.
     *
     * @param int $siteId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getTopTenMapCompetitor(int $siteId, string $startDate, string $endDate): array;

    /**
     * Get the search volume ranking for a competitor's keywords within a date range.
     *
     * @param int $siteId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getCompetitorsSearchVolumeRankingWithSite(int $siteId, string $startDate, string $endDate): array;

    /**
     * Get the losers and winners (keywords with the most rank changes) within a limit.
     *
     * @param int $limit
     * @return array
     */
    public function getLosersWinners(int $limit): array;

    /**
     * Analyze keywords for a competitor's site.
     *
     * @param int $siteId
     * @return array
     */
    public function analyzeKeywordsCompetitor(int $siteId): array;

    /**
     * Get the keywords with decreased ranks for a site.
     *
     * @param int $siteId
     * @return array
     */
    public function getGainersLosersDecreased(int $siteId): array;

    /**
     * Get the keywords with increased ranks for a site.
     *
     * @param int $siteId
     * @return array
     */
    public function getGainersLosersIncreased(int $siteId): array;

    /**
     * Get the keyword position flow (changes in ranks) for today.
     *
     * @return array
     */
    public function getKeywordPositionFlow(): array;
}
