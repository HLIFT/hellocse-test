<?php

namespace App\Http\Requests;

use App\Enums\ProfileStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            "first_name" => ["required","string"],
            "last_name" => ["required","string"],
            "status" => ["required","string", Rule::in(ProfileStatus::cases())],
            "image" => ["nullable","image", "mimes:jpg,jpeg,png"],
        ];
    }

    public function messages(): array
    {
        return [
            "first_name.required" => "Le prénom est requis",
            "first_name.string" => "Le prénom doit être uen chaîne de caractères.",
            "last_name.required" => "Le nom est requis",
            "last_name.string" => "Le nom doit être uen chaîne de caractères.",
            "status.required" => "Le statut est requis.",
            "status.in" => "La valeur du statut est erronée.",
            "image.mimes" => "L'image doit être au format jpg, jpeg ou png.",
        ];
    }
}
