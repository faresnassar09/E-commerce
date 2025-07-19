<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class Store extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string','email', 'max:120', 'unique:sellers'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_numbers' => ['required','min:9','max:50'],
            'image' => [
                'nullable', 
                'image', 
                'mimes:jpeg,png,jpg,gif,svg',   
                'max:2048', ]
            ];  
    }
}
