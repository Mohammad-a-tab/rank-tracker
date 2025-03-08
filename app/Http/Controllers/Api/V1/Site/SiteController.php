<?php

namespace App\Http\Controllers\Api\V1\Site;

use Carbon\Carbon;
use App\Models\Site;
use App\Models\SiteDetail;
use App\Imports\ImportSite;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Site\SiteGetTitleRequest;
use App\Http\Requests\Api\V1\Site\SiteImportUrlRequest;
use App\Http\Requests\Api\V1\Site\MonthlyProgressRequest;

class SiteController extends Controller
{
    use JsonResponseTrait;

    public function getAllSites(): JsonResponse
    {
        $sites = Site::all()->select(['id', 'url']);

        return $this->successResponse(
            'عملیات موفق!',
            [
                'sites' => $sites
            ]
        );
    }

    /**
     * @param MonthlyProgressRequest $request
     * @return JsonResponse
     */
    public function monthlyProgress(MonthlyProgressRequest $request): JsonResponse
    {
        try {
            $data           = $request->validated();
            $firstDate      = Carbon::parse($data['first_date'])->format('Y-m-d 00:00:00');
            $lastDate       = Carbon::parse($data['last_date'])->format('Y-m-d 23:59:59');
            $resultArray    = [];

            $results    = SiteDetail::select(

                DB::raw('DATE(sd.created_at) as date'),
                'sd.rank',
                DB::raw('(SELECT k.name FROM keywords k WHERE k.id = sd.keyword_id) AS keyword')
            )
                ->from('site_details as sd')
                ->where('sd.site_id', $data['site_id'])
                ->where('sd.keyword_id', $data['keyword_id'])
                ->whereBetween('sd.created_at', [$firstDate, $lastDate])
                ->get();

            foreach ($results as $key => $item) {
                $item['date'] = jdate($item->date)->format('Y/m/d');

                $resultArray[$key] = $item;
            }

            return $this->successResponse(
                'عملیات موفق!',
                $resultArray
            );

        } catch (\Exception $e) {
            return $this->errorResponse(
                'مشکل در سیستم',
                500
            );
        }
    }

    /**
     * @param SiteGetTitleRequest $request
     * @return JsonResponse
     */
    public function getTitleForUrlSite(SiteGetTitleRequest $request): JsonResponse
    {
        $data   = $request->validated();

        $titles = SiteDetail::query()
            ->join('keywords', 'keywords.id', '=', 'site_details.keyword_id')
            ->where('site_details.site_id', $data['site_id'])
            ->where('keywords.name', $data['keyword'])
            ->select('title')
            ->distinct()
            ->get();


        return $this->successResponse(
            'عملیات موفق!',
            $titles
        );
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

            return $this->successResponse(
                'عملیات اضافه کردن آدرس سایت با موفقیت انجام شد'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'عملیات اضافه کردن آدرس سایت با مشکلی مواجه شد',
                500
            );
        }
    }
}
