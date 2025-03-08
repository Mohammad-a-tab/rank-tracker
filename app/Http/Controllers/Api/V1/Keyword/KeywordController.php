<?php

namespace App\Http\Controllers\Api\V1\Keyword;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\KeywordRepositoryInterface;
use App\Http\Requests\Api\V1\Keyword\{
    KeywordTop3Request,
    KeywordTop10Request,
    KeywordImportRequest,
    KeywordVolumeRequest,
    KeywordLosersWinners,
    KeywordProgressRequest,
    KeywordDistributionRequest,
    KeywordGainersLosersRequest,
    KeywordAveragePositionRequest,
    KeywordTopOneCompetitorRequest,
    KeywordTopTenCompetitorRequest,
    KeywordAnalyzeCompetitorRequest,
    KeywordCompetitorsAverageRequest,
    KeywordAverageHistoryCompetitorRequest,
    KeywordCompetitorsSearchVolumeRankingRequest
};
use Illuminate\Http\JsonResponse;
use App\Traits\JsonResponseTrait;

class KeywordController extends Controller
{
    use JsonResponseTrait;

    private $keywordRepository;

    public function __construct(KeywordRepositoryInterface $keywordRepository)
    {
        $this->keywordRepository = $keywordRepository;
    }

    public function getAllKeywords(): JsonResponse
    {
        $keywords = $this->keywordRepository->getAllKeywords();
        return $this->successResponse('عملیات موفق!', ['keywords' => $keywords]);
    }

    public function keywordProgress(KeywordProgressRequest $request): JsonResponse
    {
        $data = $request->validated();
        $progress = $this->keywordRepository->getKeywordProgress($data['site_id'], $data['keyword_id'], $data['first_date'], $data['last_date']);
        return $this->successResponse('عملیات موفق!', $progress);
    }

    public function keywordTop3(KeywordTop3Request $request): JsonResponse
    {
        $data = $request->validated();
        $results = $this->keywordRepository->getKeywordTop3($data['site_id'], $data['first_date'], $data['last_date'], $data['limit'] ?? 50);
        return $this->successResponse('عملیات موفق!', $results);
    }

    public function keywordTop10(KeywordTop10Request $request): JsonResponse
    {
        $data = $request->validated();
        $results = $this->keywordRepository->getKeywordTop10($data['site_id'], $data['first_date'], $data['last_date'], $data['limit'] ?? 50);
        return $this->successResponse('عملیات موفق!', $results);
    }

    public function importKeyword(KeywordImportRequest $request): JsonResponse
    {
        try {
            $request->validated();
            $this->keywordRepository->importKeywords($request->all());
            return $this->successResponse('عملیات اضافه کردن کلید با موفقیت انجام شد');
        } catch (\Exception $e) {
            return $this->errorResponse('عملیات اضافه کردن کلید با مشکلی مواجه شد', 500);
        }
    }

    public function averagePosition(KeywordAveragePositionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $averageRanks = $this->keywordRepository->getAveragePosition($data['site_ids'], $data['keywords'], $data['first_date'], $data['last_date']);
        return $this->successResponse('عملیات با موفقیت انجام شد', $averageRanks);
    }

    public function competitorsSearchVolumeRankingWithAllSites(KeywordVolumeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $keywords = $this->keywordRepository->getCompetitorsSearchVolumeRanking($data['limit'] ?? 1, 50);
        return $this->successResponse('عملیات با موفقیت انجام شد', $keywords);
    }

    public function competitorsTopOneMapToday(): JsonResponse
    {
        $data = $this->keywordRepository->getCompetitorsTopOneMapToday();
        return $this->successResponse('عملیات با موفقیت انجام شد', $data);
    }

    public function competitorsTopThreeMapToday(): JsonResponse
    {
        $data = $this->keywordRepository->getCompetitorsTopThreeMapToday();
        return $this->successResponse('عملیات با موفقیت انجام شد', $data);
    }

    public function competitorsTopTenMapToday(): JsonResponse
    {
        $data = $this->keywordRepository->getCompetitorsTopTenMapToday();
        return $this->successResponse('عملیات با موفقیت انجام شد', $data);
    }

    public function competitorsAverageMapToday(KeywordCompetitorsAverageRequest $request): JsonResponse
    {
        $data = $request->validated();
        $averageRanks = $this->keywordRepository->getCompetitorsAverageMapToday($data['keywords']);
        return $this->successResponse('عملیات با موفقیت انجام شد', ['averageRanks' => $averageRanks]);
    }

    public function analyzeKeywords(): JsonResponse
    {
        $data = $this->keywordRepository->analyzeKeywords();
        return $this->successResponse('عملیات با موفقیت انجام شد', $data);
    }

    public function keywordPositionDistribution(KeywordDistributionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $distribution = $this->keywordRepository->getKeywordPositionDistribution($data['site_id']);
        return $this->successResponse('عملیات با موفقیت انجام شد', $distribution);
    }

    public function averageHistoryReportCompetitor(KeywordAverageHistoryCompetitorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->getAverageHistoryReportCompetitor($data['site_id'], $data['first_date'], $data['last_date']);
        return $this->successResponse('عملیات با موفقیت انجام شد', $report);
    }

    public function topOneMapCompetitor(KeywordTopOneCompetitorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->getTopOneMapCompetitor($data['site_id'], $data['first_date'], $data['last_date']);
        return $this->successResponse('عملیات با موفقیت انجام شد', $report);
    }

    public function topThreeMapCompetitor(KeywordTopThreeCompetitorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->getTopThreeMapCompetitor($data['site_id'], $data['first_date'], $data['last_date']);
        return $this->successResponse('عملیات با موفقیت انجام شد', $report);
    }

    public function topTenMapCompetitor(KeywordTopTenCompetitorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->getTopTenMapCompetitor($data['site_id'], $data['first_date'], $data['last_date']);
        return $this->successResponse('عملیات با موفقیت انجام شد', $report);
    }

    public function competitorsSearchVolumeRanking(KeywordCompetitorsSearchVolumeRankingRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->getCompetitorsSearchVolumeRankingWithSite($data['site_id'], $data['first_date'], $data['last_date']);
        return $this->successResponse('عملیات با موفقیت انجام شد', $report);
    }

    public function losersWinners(KeywordLosersWinners $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->getLosersWinners($data['limit']);
        return $this->successResponse('عملیات موفق!', $report);
    }

    public function analyzeKeywordsCompetitor(KeywordAnalyzeCompetitorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->analyzeKeywordsCompetitor($data['site_id']);
        return $this->successResponse('عملیات با موفقیت انجام شد', $report);
    }

    public function gainersLosersDecreased(KeywordGainersLosersRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->getGainersLosersDecreased($data['site_id']);
        return $this->successResponse('عملیات موفق!', $report);
    }

    public function gainersLosersIncreased(KeywordGainersLosersRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->getGainersLosersIncreased($data['site_id']);
        return $this->successResponse('عملیات موفق!', $report);
    }

    public function keywordPositionFlow(): JsonResponse
    {
        $report = $this->keywordRepository->getKeywordPositionFlow();
        return $this->successResponse('عملیات موفق!', $report);
    }
}
