<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keyword extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'keywords';

    /**
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->HasMany(SiteDetail::class);
    }

    /**
     * @return HasMany
     */
    public function keywordsRanks(): HasMany
    {
        return $this->hasMany(KeywordRanks::class , 'keyword_id', 'id');
    }
}
