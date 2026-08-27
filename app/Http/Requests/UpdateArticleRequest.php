<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // pour l'instant, tout le monde
    }

    // Les règles de validation
    public function rules(): array
    {
        return [
            'titre' => 'required|min:3|max:255',
            'contenu' => 'required',
        ];
    }
}
