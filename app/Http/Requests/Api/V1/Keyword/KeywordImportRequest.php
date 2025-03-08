<?php

namespace App\Http\Requests\Api\V1\Keyword;

use Illuminate\Foundation\Http\FormRequest;

class KeywordImportRequest extends FormRequest
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
            'file'      => 'required|mimes:xlsx,csv,doc,docx,ppt,pptx,ods,odt,odp,application/csv,application/excel,
                            application/vnd.ms-excel'
        ];
    }
}
