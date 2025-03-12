<?php

namespace App\Http\Controllers\Api\V1\Keyword;

use App\Imports\ImportKeyword;
use Illuminate\Http\JsonResponse;
use App\Traits\JsonResponseTrait;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\keyword\KeywordsResource;
use App\Http\Requests\Api\V1\Keyword\KeywordFilterRequest;
use App\Http\Requests\Api\V1\Keyword\KeywordImportRequest;
use App\Repositories\Eloquent\Contracts\KeywordRepositoryInterface;

class KeywordController extends Controller
{
    use JsonResponseTrait;

    public function __construct
    (
        private readonly KeywordRepositoryInterface $keywordRepository
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
     * @param int $siteId
     * @return JsonResponse
     */
    public function analyzeKeywordsCompetitor(int $siteId): JsonResponse
    {
        $report = $this->keywordRepository->analyzeKeywordsCompetitor($siteId);
        return $this->successResponse(__('messages.operation_successfully'), $report);
    }
}
