<?php

namespace App\Http\Controllers\Api\V1\Site;

use App\Imports\ImportSite;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Site\SiteGetTitleRequest;
use App\Http\Requests\Api\V1\Site\SiteImportUrlRequest;
use App\Repositories\Eloquent\Contracts\SiteRepositoryInterface;
use App\Repositories\Eloquent\Contracts\SiteDetailRepositoryInterface;

class SiteController extends Controller
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
     * @return JsonResponse
     */
    public function getAllSites(): JsonResponse
    {
        $sites = $this->siteRepository->query()->select(['id', 'url'])->get();

        return $this->successResponse(__('messages.operation_successfully'), ['sites' => $sites]);
    }

    /**
     * @param SiteGetTitleRequest $request
     * @return JsonResponse
     */
    public function getTitleForUrlSite(SiteGetTitleRequest $request): JsonResponse
    {
        $data   = $request->validated();
        $titles = $this->siteDetailRepository->getDistinctTitlesBySiteAndKeyword($data['site_id'], $data['keyword_name']);

        return $this->successResponse(__('messages.operation_successfully'), $titles);
    }

    /**
     * @param SiteImportUrlRequest $request
     * @return JsonResponse
     */
    public function importSiteUrl(SiteImportUrlRequest $request): JsonResponse
    {
        try {
            $request->validated();

            Excel::import(new ImportSite(),
                $request->file('file')->store('files/sites'));

            return $this->successResponse(__('messages.successfully_added_site'));
        } catch (\Throwable $e) {
            report($e);
            return $this->errorResponse(__('messages.failed_added_site'), 500);
        }
    }
}
