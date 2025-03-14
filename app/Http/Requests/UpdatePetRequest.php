<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category.id' => ['nullable', 'integer'],
            'category.name' => ['nullable', 'string'],
            'name' => ['nullable', 'string'],
            'photoUrls' => ['required', 'string'],
            'tags' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
        ];
    }
}
