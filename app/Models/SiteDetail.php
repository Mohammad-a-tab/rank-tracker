<?php

namespace App\Models;


use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function keyword(): BelongsTo
    {
        return $this->belongsTo(Keyword::class, 'keyword_id');
    }

    public function scopeAveragePosition(Builder $query, $siteId,$keywordIds,$firstDate,$lastDate)
    {
        return $query->selectRaw('DATE(site_details.created_at) as created_date, AVG(`rank`) as average_rank')
            ->where('site_id', $siteId)
            ->whereBetween('created_at', [$firstDate, $lastDate])
            ->when($keywordIds, function ($query, $keywordIds) {
                $query->whereIn('keyword_id', $keywordIds);
            })
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();
    }

    public static function fillMissingDates(Collection $results, $firstDate, $lastDate): array
    {
        $dates = self::getDatesBetween($firstDate, $lastDate);
        $filledResults = [];

        foreach ($dates as $date => $value) {
            $filledResults[$date] = $results->get($date, '0');
        }

        return $filledResults;
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public static function getDatesBetween($startDate, $endDate): array
    {
        $dates = [];
        $startDate = new Carbon($startDate);
        $endDate = new Carbon($endDate);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dates[$date->format('Y-m-d')] = "";
        }

        return $dates;
    }


}
