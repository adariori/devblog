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
        // "sometimes" : permet une mise à jour partielle (utile pour l'API).
        // Le formulaire web envoie toujours les deux champs, donc rien ne change côté web.
        return [
            'titre' => 'sometimes|required|min:3|max:255',
            'contenu' => 'sometimes|required',
            'cover' => 'nullable|image|max:2048',
        ];
    }
}
