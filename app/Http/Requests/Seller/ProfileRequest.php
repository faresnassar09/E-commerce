<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class ProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'name' => ['nullable', 'min:4'],

        ];
    }
}
