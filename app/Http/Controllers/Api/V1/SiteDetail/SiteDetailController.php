<?php

namespace App\Http\Controllers\Api\V1\SiteDetail;

use Illuminate\Http\JsonResponse;
use App\Traits\JsonResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Site\SiteCompetitorRequest;
use App\Http\Requests\Api\V1\Site\MonthlyProgressRequest;
use App\Http\Requests\Api\V1\Keyword\KeywordFilterRequest;
use App\Http\Requests\Api\V1\Keyword\KeywordProgressRequest;
use App\Repositories\Eloquent\Contracts\SiteRepositoryInterface;
use App\Http\Requests\Api\V1\Keyword\KeywordAveragePositionRequest;
use App\Repositories\Eloquent\Contracts\SiteDetailRepositoryInterface;

class SiteDetailController extends Controller
{
    use JsonResponseTrait;

    public function __construct
    (
        private readonly SiteRepositoryInterface $siteRepository,
        private readonly SiteDetailRepositoryInterface $siteDetailRepository
    )
    {
        //
    }

    /**
     * @param KeywordProgressRequest $request
     * @return JsonResponse
     */
    public function keywordProgress(KeywordProgressRequest $request): JsonResponse
    {
        $data = $request->validated();
        $progress = $this->siteDetailRepository->getSiteKeywordProgress($data['site_id'], $data['keyword_id'], $data['first_date'], $data['last_date']);
        return $this->successResponse(__('messages.operation_successfully'), $progress);
    }

    /**
     * @param KeywordFilterRequest $request
     * @return JsonResponse
     */
    public function siteKeywordTop3(KeywordFilterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $results = $this->siteDetailRepository->getRankedSites($data['site_id'], $data['first_date'], $data['last_date'], [1, 3], $data['limit'] ?? 50);
        return $this->successResponse(__('messages.operation_successfully'), $results);
    }

    /**
     * @param KeywordFilterRequest $request
     * @return JsonResponse
     */
    public function siteKeywordTop10(KeywordFilterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $results = $this->siteDetailRepository->getRankedSites($data['site_id'], $data['first_date'], $data['last_date'], [1, 10], $data['limit'] ?? 50);
        return $this->successResponse(__('messages.operation_successfully'), $results);
    }

    /**
     * @param KeywordAveragePositionRequest $request
     * @return JsonResponse
     */
    public function averagePosition(KeywordAveragePositionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $averageRanks = $this->siteDetailRepository->getAveragePosition($data['site_ids'], $data['keywords'], $data['first_date'], $data['last_date']);
        return $this->successResponse(__('messages.operation_successfully'), $averageRanks);
    }

    /**
     * @param int $siteId
     * @return JsonResponse
     */
    public function analyzeKeywords(int $siteId): JsonResponse
    {
        $site = $this->siteRepository->findOrFail($siteId);
        $data = $this->siteDetailRepository->analyzeKeywords($site->id);
        return $this->successResponse(__('messages.operation_successfully'), $data);
    }

    /**
     * @param SiteCompetitorRequest $request
     * @return JsonResponse
     */
    public function averageHistoryReportCompetitor(SiteCompetitorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->siteDetailRepository->getAverageHistoryReportCompetitor($data['site_ids'], $data['first_date'], $data['last_date']);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }

    /**
     * @param SiteCompetitorRequest $request
     * @return JsonResponse
     */
    public function topThreeMapCompetitor(SiteCompetitorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->siteDetailRepository->topSiteCompetitor($data['site_ids'], [1,3], $data['first_date'], $data['last_date']);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }

    /**
     * @param SiteCompetitorRequest $request
     * @return JsonResponse
     */
    public function topTenMapCompetitor(SiteCompetitorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->siteDetailRepository->topSiteCompetitor($data['site_ids'], [1,10], $data['first_date'], $data['last_date']);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }

    /**
     * @param SiteCompetitorRequest $request
     * @return JsonResponse
     */
    public function competitorsSearchVolumeRanking(SiteCompetitorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->siteDetailRepository->getSiteSearchVolume($data['site_ids'], $data['first_date'], $data['last_date']);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }

    /**
     * @param int $siteId
     * @return array
     */
    public function keywordPositionFlow(int $siteId): array
    {
        $date = now()->toDateString();

        return [
            'wentUp'    => $this->siteDetailRepository->getKeywordRankChanges($siteId, $date, 'up'),
            'wentDown'  => $this->siteDetailRepository->getKeywordRankChanges($siteId, $date, 'down'),
            'unchanged' => $this->siteDetailRepository->getKeywordRankChanges($siteId, $date, 'unchanged'),
        ];
    }

    /**
     * @param MonthlyProgressRequest $request
     * @return JsonResponse
     */
    public function getSiteDetails(MonthlyProgressRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->siteDetailRepository->getSiteDetailsWithKeyword(
            $data['site_id'],
            $data['keyword_id'],
            $data['first_date'],
            $data['last_date']
        );

        return $this->successResponse(__('messages.operation_successfully'), $result);
    }
}
