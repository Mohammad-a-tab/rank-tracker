<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteDetail extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * @return BelongsTo
     */
    public function keyword(): BelongsTo
    {
        return $this->belongsTo(Keyword::class, 'keyword_id');
    }

    /**
     * @param Collection $results
     * @param $firstDate
     * @param $lastDate
     * @return array
     */
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
