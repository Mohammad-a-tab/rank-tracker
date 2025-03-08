<?php

namespace App\Http\Requests\Api\V1\Keyword;

use Illuminate\Foundation\Http\FormRequest;

class KeywordProgressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'site_id'       => 'required|integer|exists:sites,id',
            'keyword_id'    => 'required|integer|exists:keywords,id',
            'first_date'    => 'required|date',
            'last_date'     => 'required|date',
        ];
    }
}
