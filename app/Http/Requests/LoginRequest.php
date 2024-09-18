<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
        $rule = [
            'email' => 'required | email',
            'password' => 'required'
        ];

        if (Request::has('user_code')) {
            $rule = [
                'email' => 'nullable | email',
                'password' => 'nullable',
                'user_code' => 'required',
                'admin_code' => 'required',
            ];
        }

        return $rule;
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'password.required' => 'Please enter password',
        ];
    }
}
