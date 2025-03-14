<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category.id' => ['required', 'integer'],
            'category.name' => ['required', 'string'],
            'name' => ['required', 'string'],
            'photoUrls' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
            'status' => ['required', 'string'],
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        \Log::info('Failed validation', [
            'request_data' => $this->validated(),
            'errors' => $validator->errors()
        ]);
        parent::failedValidation($validator);
    }
}
