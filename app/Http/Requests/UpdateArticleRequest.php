<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // "sometimes" : permet une mise à jour partielle (utile pour l'API).
        // Le formulaire web envoie toujours titre + contenu, donc rien ne change côté web.
        return [
            'titre' => 'sometimes|required|min:3|max:255',
            'contenu' => 'sometimes|required',
            'cover' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
        ];
    }
}
