<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempKeyword extends Model
{
    use HasFactory;

    protected $table = 'temp_keywords';

    protected $guarded = ['id'];
}
