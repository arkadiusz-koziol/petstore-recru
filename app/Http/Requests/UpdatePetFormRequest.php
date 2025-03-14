<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'status' => ['string'],
        ];
    }
}
