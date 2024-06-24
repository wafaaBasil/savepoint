<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'phonenumber' => 'numeric|required|size:9',
            'password' => 'string|required',
            'device_token' => 'string|required',
        ];
    }

    public function messages(): array
    {
        return [
            'phonenumber.required' => 'A title is required',
            'password.required' => 'A message is required',
            'device_token.required' => 'A message is required',
            'phonenumber.numeric' => 'A title is number',
            'phonenumber.size' => 'A title is 9 digits',
            'password.string' => 'A message is string',
            'device_token.string' => 'A message is string',
        ];
    }
    
}
