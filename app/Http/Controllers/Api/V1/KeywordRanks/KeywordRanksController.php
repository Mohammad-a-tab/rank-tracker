<?php

namespace App\Http\Controllers\Api\V1\KeywordRanks;

use Illuminate\Http\JsonResponse;
use App\Traits\JsonResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\keyword\RankKeywordResource;
use App\Http\Requests\Api\V1\Keyword\KeywordFilterRequest;
use App\Http\Requests\Api\V1\Keyword\KeywordGainersLosersRequest;
use App\Repositories\Eloquent\Contracts\KeywordRepositoryInterface;
use App\Http\Requests\Api\V1\Keyword\KeywordCompetitorsAverageRequest;
use App\Repositories\Eloquent\Contracts\KeywordRanksRepositoryInterface;

class KeywordRanksController extends Controller
{
    use JsonResponseTrait;

    public function __construct
    (
        private readonly KeywordRepositoryInterface $keywordRepository,
        private readonly KeywordRanksRepositoryInterface $keywordRanksRepository,
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function competitorsTopThreeMapToday(): JsonResponse
    {
        $data = $this->keywordRanksRepository->getCompetitorsTopSitesToday([1, 3]);
        return $this->successResponse(__('messages.operation_successfully'), $data);
    }

    /**
     * @return JsonResponse
     */
    public function competitorsTopTenMapToday(): JsonResponse
    {
        $data = $this->keywordRanksRepository->getCompetitorsTopSitesToday([1, 10]);
        return $this->successResponse(__('messages.operation_successfully'), $data);
    }

    /**
     * @param KeywordCompetitorsAverageRequest $request
     * @return JsonResponse
     */
    public function competitorsAverageMapToday(KeywordCompetitorsAverageRequest $request): JsonResponse
    {
        $data = $request->validated();
        $averageRanks = $this->keywordRanksRepository->getCompetitorsAverageMapToday($data['keywordIds']);
        return $this->successResponse(__('messages.operation_successfully'), ['averageRanks' => $averageRanks]);
    }

    /**
     * @param KeywordFilterRequest $request
     * @return JsonResponse
     */
    public function keywordPositionDistribution(KeywordFilterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $keywords = $this->keywordRepository->query()->count();
        $distribution = $this->keywordRanksRepository->getRankStatistics($data['site_id'], $keywords);
        return $this->successResponse(__('messages.operation_successfully'), $distribution);
    }

    /**
     * @param KeywordFilterRequest $request
     * @return JsonResponse
     */
    public function losersWinners(KeywordFilterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $report = $this->keywordRanksRepository->getLosersWinners($data['limit']);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }

    /**
     * @param KeywordGainersLosersRequest $request
     * @return JsonResponse
     */
    public function getGainersLosers(KeywordGainersLosersRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->keywordRanksRepository->getRankChangesByType($data['site_id'], $data['type']);
        $report = RankKeywordResource::collection($result)->values()->toArray();
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }
}
