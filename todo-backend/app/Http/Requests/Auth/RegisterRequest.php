<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed', // Checks against password_confirmation
                Password::min(8)
                    ->letters()
                    ->numbers()
                    // ->mixedCase() // Uncomment if you want stricter security
                    // ->symbols()   // Uncomment if you want stricter security
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // Name messages
            'name.required' => 'Please enter your full name.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name may not be greater than 255 characters.',

            // Email messages
            'email.required' => 'Please enter your email address.',
            'email.string' => 'The email must be a valid string.',
            'email.email' => 'The email format is invalid.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'This email address is already registered.',

            // Password messages
            'password.required' => 'Please enter a password.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }
}
