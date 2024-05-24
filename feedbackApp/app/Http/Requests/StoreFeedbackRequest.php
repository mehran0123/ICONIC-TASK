<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'product_title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
            'product_title.required' => 'The product title is required.',
            'description.required' => 'The description is required.',
            'category.required' => 'The category is required.',
            'category.in' => 'The category must be one of the following: bug report, feature request, improvement.',
        ];
    }
}
