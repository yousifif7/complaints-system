<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'createdCatName' => 'required|string|max:255',
            'createdCatName_en' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'createdCatName.required' => __('messages.validation_department_required'),
        ];
    }
}
