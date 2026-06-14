<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{7,15}$/',
            'content' => 'required|string|max:5000',
            'formtype' => 'required|exists:request_types,id',
            'category' => 'required|exists:categories,id',
            'userfile' => 'nullable|mimes:png,jpg,jpeg,pdf|max:10000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.validation_name_required'),
            'address.required' => __('messages.validation_address_required'),
            'phone.required' => __('messages.validation_phone_required'),
            'phone.regex' => __('messages.validation_phone_invalid'),
            'content.required' => __('messages.validation_content_required'),
            'formtype.required' => __('messages.validation_category_required'),
            'userfile.mimes' => __('messages.validation_file_type'),
            'userfile.max' => __('messages.validation_file_size'),
        ];
    }
}
