<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ["required","string","email"],
            'password' => ["required","string","min:8"]
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Le champs email est requis.',
            'email.string' => 'Le champs email doit être une chaîne de caractères.',
            'email.email' => 'Le format du champs email est incorrect.',
            'password.required' => 'Le champs password est requis.',
            'password.string' => 'Le champs password doit être une chaîne de caractères.',
            'password.min' => 'Le champs password doit faire au minimum 8 caractères.',
        ];
    }
}
