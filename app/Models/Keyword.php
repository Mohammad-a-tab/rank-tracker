<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = ['keyword_url', 'keyword_name', 'keyword_volume'];

    protected $table = 'keywords';

    public function details(): HasMany
    {
        return $this->HasMany(SiteDetail::class);
    }

    public function keywordsRanks(): HasMany
    {
        return $this->hasMany(KeywordsRanks::class , 'keyword_id', 'id');
    }
}
