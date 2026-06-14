<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'createdRequest' => 'required|string|max:255',
            'createdRequest_en' => 'nullable|string|max:255',
            'formCat' => 'required|exists:categories,id',
        ];
    }
}
