<?php

namespace App\Http\Requests\Api\V1\Keyword;

use Illuminate\Foundation\Http\FormRequest;

class KeywordLosersWinners extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'limit'      => 'required|integer|min:5|max:20',
        ];
    }
}
