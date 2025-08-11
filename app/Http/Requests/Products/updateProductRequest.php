<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateProductRequest extends FormRequest
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


            'name' => ['min:6', 'max:255', Rule::unique('products')->ignore($this->id)],
            'description' => ['min:10', 'max:1000'],
            'price' =>       ['numeric', 'min:1', 'max:500'],
            'discount' =>    ['lt:price'],
            'images.*' =>    ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048',],


        ];
    }
}
