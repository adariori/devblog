<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => [
                'required', 'min:2', 'max:50',
                Rule::unique('categories', 'nom')->ignore($this->route('category')),
            ],
        ];
    }
}
