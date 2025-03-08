<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeywordsRanks extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "keywords_ranks";

    public function details() : HasMany
    {
        return $this->hasMany(SiteDetail::class);
    }

    public function keyword() : BelongsTo
    {
        return $this->belongsTo(Keyword::class , 'keyword_id');
    }

    public function sites() : BelongsTo
    {
        return $this->belongsTo(Site::class,'site_id');
    }
    public function scopeRankChanges(Builder $query,int $siteId) :Builder
    {
        return $query->where('site_id', $siteId)
            ->select('keyword_id', 'first_rank', 'latest_rank')
            ->addSelect(\DB::raw('latest_rank - first_rank as rank_change'))
            ->orderBy('rank_change','desc');
    }

    public function scopeLastdayChanges(Builder $query) :Builder
    {
        return $query->select('site_id', 'latest_rank','keyword_id')
            ->addSelect('site_id')
            ->with('sites')
            ->orderBy('latest_rank', 'desc');
    }

    public function scopeAverageRankByKeywords(Builder $query, array $keywordIds) :Builder
    {
        return $query->whereIn('keyword_id', $keywordIds)
            ->select('site_id', \DB::raw('AVG(latest_rank) as average_rank'))
            ->groupBy('site_id');
    }

    public function scopeWithDetails($query)
    {
        return $query->select(
            'keywords_ranks.site_id',
            'keywords_ranks.keyword_id',
            'keywords_ranks.first_rank',
            'keywords_ranks.latest_rank',
            DB::raw('(keywords_ranks.first_rank - keywords_ranks.latest_rank) as rank_change'),
            'sites.url as siteURL',
            'keywords.name as keywordName'
        )
            ->join('sites', 'keywords_ranks.site_id', '=', 'sites.id')
            ->join('keywords', 'keywords_ranks.keyword_id', '=', 'keywords.id');
    }
}
