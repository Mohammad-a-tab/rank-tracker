<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeywordRanks extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = "keywords_ranks";

    /**
     * @return HasMany
     */
    public function details() : HasMany
    {
        return $this->hasMany(SiteDetail::class);
    }

    /**
     * @return BelongsTo
     */
    public function keyword() : BelongsTo
    {
        return $this->belongsTo(Keyword::class , 'keyword_id');
    }

    /**
     * @return BelongsTo
     */
    public function sites() : BelongsTo
    {
        return $this->belongsTo(Site::class,'site_id');
    }

    /**
     * @param Builder $query
     * @param int $siteId
     * @return Builder
     */
    public function scopeRankChanges(Builder $query, int $siteId): Builder
    {
        return $query->where('site_id', $siteId)
            ->select('keyword_id', 'first_rank', 'latest_rank')
            ->addSelect(DB::raw('latest_rank - first_rank as rank_change'))
            ->with('keyword')
            ->orderBy('rank_change','desc');
    }

    /**
     * @param $query
     * @return Builder
     */
    public function scopeWithRankChanges($query): Builder
    {
        return $query->select(
            'site_id',
            'keyword_id',
            'first_rank',
            'latest_rank',
            DB::raw('(first_rank - latest_rank) as rank_change')
        )
            ->whereNotNull('first_rank')
            ->whereNotNull('latest_rank')
            ->with(['site:id,url', 'keyword:id,name']);
    }
}
