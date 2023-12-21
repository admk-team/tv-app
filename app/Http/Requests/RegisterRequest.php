<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => "required",
            "email" => "required|email",
            "password" => "required|confirmed|min:6",
            "password_confirmation" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter Name',
            'email.required' => 'Please enter Email',
            'password.required' => 'Please enter Password',
            'password_confirmation.required' => 'Please enter Confirm Password'
        ];
    }
}
