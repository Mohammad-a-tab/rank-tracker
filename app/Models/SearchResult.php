<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchResult extends Model
{
    use HasFactory;

    protected $table = 'search_results';

    protected $guarded = ['id'];
}
