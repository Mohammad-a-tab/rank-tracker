<?php

namespace App\Http\Controllers\Api\V1\Keyword;

use App\Http\Resources\keyword\KeywordsResource;
use App\Imports\ImportKeyword;
use App\Repositories\Eloquent\Contracts\SiteDetailRepositoryInterface;
use App\Repositories\Eloquent\Contracts\SiteRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Traits\JsonResponseTrait;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\Contracts\KeywordRepositoryInterface;
use App\Http\Requests\Api\V1\Keyword\{
    KeywordFilterRequest,
    KeywordImportRequest,
    KeywordCompetitorsAverageRequest,
};
use Maatwebsite\Excel\Facades\Excel;

class KeywordController extends Controller
{
    use JsonResponseTrait;

    public function __construct
    (
        private readonly SiteRepositoryInterface $siteRepository,
        private readonly KeywordRepositoryInterface $keywordRepository,
        private readonly SiteDetailRepositoryInterface $siteDetailRepository
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function getAllKeywords(): JsonResponse
    {
        $keywords = $this->keywordRepository->getAllKeywords();
        return $this->successResponse(__('messages.operation_successfully'), ['keywords' => $keywords]);
    }

    /**
     * @param KeywordImportRequest $request
     * @return JsonResponse
     */
    public function importKeyword(KeywordImportRequest $request): JsonResponse
    {
        try {
            Excel::queueImport(new ImportKeyword(),
                $request->file('file')->store('files/keywords'));

            return $this->successResponse(__('messages.keyword_successfully_added'));
        } catch (\Throwable $e) {
            report($e);
            return $this->errorResponse(__('messages.keyword_add_failed'), 500);
        }
    }

    /**
     * @param KeywordFilterRequest $request
     * @return JsonResponse
     */
    public function competitorsSearchVolumeRankingWithAllSites(KeywordFilterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $offset = ($data['limit']  - 1) * 50;
        $keywords = $this->keywordRepository->getCompetitorsSearchVolumeRanking($offset, 50);

        return $this->successResponse(__('messages.operation_successfully'), KeywordsResource::collection($keywords));
    }

    /**
     * @return JsonResponse
     */
    public function competitorsTopOneMapToday(): JsonResponse
    {
        $data = $this->keywordRepository->getCompetitorsTopOneMapToday();
        return $this->successResponse(__('messages.operation_successfully'), $data);
    }

    /**
     * @return JsonResponse
     */
    public function competitorsTopThreeMapToday(): JsonResponse
    {
        $data = $this->keywordRepository->getCompetitorsTopThreeMapToday();
        return $this->successResponse(__('messages.operation_successfully'), $data);
    }

    /**
     * @return JsonResponse
     */
    public function competitorsTopTenMapToday(): JsonResponse
    {
        $data = $this->keywordRepository->getCompetitorsTopTenMapToday();
        return $this->successResponse(__('messages.operation_successfully'), $data);
    }

    /**
     * @param KeywordCompetitorsAverageRequest $request
     * @return JsonResponse
     */
    public function competitorsAverageMapToday(KeywordCompetitorsAverageRequest $request): JsonResponse
    {
        $data = $request->validated();
        $averageRanks = $this->keywordRepository->getCompetitorsAverageMapToday($data['keywords']);
        return $this->successResponse(__('messages.operation_successfully'), ['averageRanks' => $averageRanks]);
    }

    /**
     * @param KeywordFilterRequest $request
     * @return JsonResponse
     */
    public function keywordPositionDistribution(KeywordFilterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $distribution = $this->keywordRepository->getKeywordPositionDistribution($data['site_id']);
        return $this->successResponse(__('messages.operation_successfully'), $distribution);
    }



    /**
     * @param KeywordFilterRequest $request
     * @return JsonResponse
     */
    public function losersWinners(KeywordFilterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRepository->getLosersWinners($data['limit']);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }

    /**
     * @param int $siteId
     * @return JsonResponse
     */
    public function analyzeKeywordsCompetitor(int $siteId): JsonResponse
    {
        $report = $this->keywordRepository->analyzeKeywordsCompetitor($siteId);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }

    /**
     * @param int $siteId
     * @return JsonResponse
     */
    public function gainersLosersDecreased(int $siteId): JsonResponse
    {
        $report = $this->keywordRepository->getGainersLosersDecreased($siteId);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }

    /**
     * @param int $siteId
     * @return JsonResponse
     */
    public function gainersLosersIncreased(int $siteId): JsonResponse
    {
        $report = $this->keywordRepository->getGainersLosersIncreased($siteId);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }


}
