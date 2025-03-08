<?php

namespace App\Http\Resources\keyword;

use Illuminate\Http\Resources\Json\JsonResource;

class LosersWinnersResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'siteURL' => $this->siteURL,
            'rankChange' => $this->rank_change,
            'firstRank' => $this->first_rank,
            'latestRank' => $this->latest_rank,
            'keywordName' => $this->keywordName,
        ];
    }
}
