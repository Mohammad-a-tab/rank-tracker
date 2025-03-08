<?php

namespace App\Http\Resources\keyword;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RankKeywordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'keyword_id'    => $this->keyword_id,
            'first_rank'    => $this->first_rank,
            'latest_rank'   => $this->latest_rank,
            'rank_change'   => $this->rank_change,
            'keyword'       => [
                'id'             => $this->keyword->id,
                'name'           => $this->keyword->name,
                'created_at'     => $this->keyword->created_at,
                'updated_at'     => $this->keyword->updated_at,
                'search_volume'  => $this->keyword->keyword_volume ,
            ],
        ];
    }
}
