<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'extrait' => substr($this->contenu, 0, 100) . '...',
            'contenu' => $this->contenu,
            'auteur' => $this->user->name,
            'publie_le' => $this->created_at->format('d/m/Y'),
        ];
    }
}
