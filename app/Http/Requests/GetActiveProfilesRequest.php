<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetActiveProfilesRequest extends FormRequest
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
            'per_page' => ["nullable","integer","min:1","max:100"],
            'page' => ["nullable","integer","min:1"],
        ];
    }

    public function messages(): array
    {
        return [
            'per_page.integer' => 'Le nombre par page doit être un entier.',
            'per_page.min' => 'Le nombre par page doit être supérieur à 0.',
            'per_page.max' => 'Le nombre par page doit être inférieur ou égal à 100.',
            'page.integer' => 'Le numéro de page doit être un entier.',
            'page.min' => 'Le numéro de page doit être supérieur à 0.',
        ];
    }
}
