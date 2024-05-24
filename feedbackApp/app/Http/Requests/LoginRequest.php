<?php

namespace App\Http\Requests;

use App\Services\BaseService;

class LoginRequest extends BaseService
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // You may adjust this based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }
}
