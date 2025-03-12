<?php

namespace App\Repositories\Eloquent\Concretions;

use App\Models\Site;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Eloquent\Contracts\SiteRepositoryInterface;

class SiteRepository extends EloquentBaseRepository implements SiteRepositoryInterface
{
    public function model(): string
    {
        return Site::class;
    }
}
