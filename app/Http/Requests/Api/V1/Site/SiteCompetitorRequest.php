<?php

namespace App\Http\Requests\Api\V1\Site;

use Illuminate\Foundation\Http\FormRequest;

class SiteCompetitorRequest extends FormRequest
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
            'site_ids'      => 'required|array',
            'site_ids.*'    => 'required|exists:sites,id',
            'limit'         => 'nullable|integer',
            'first_date'    => 'required|date',
            'last_date'     => 'required|date',
        ];
    }
}
