<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detail(): HasMany
    {
        return $this->hasMany(SiteDetail::class);
    }
}
