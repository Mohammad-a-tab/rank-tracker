<?php

namespace App\Http\Resources\keyword;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KeywordsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'keyword_url'    => $this->keyword_url,
            'name'           => $this->name,
            'keyword_volume' => $this->keyword_volume,
        ];
    }
}
