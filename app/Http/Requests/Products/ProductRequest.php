<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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

    'name' =>        ['required','min:6','max:255','unique:products'],
    'description' => ['required','min:10','max:1000'],
    'price' =>       ['numeric','min:0.1','max:500'],
    'discount' =>    ['max:150','lt:price'],
    'quantity' =>    ['numeric','min:1','max:1000'],
    'category_id' => ['required'],
    'images.*' =>    ['required','mimes:jpeg,png,jpg,gif,svg','max:2048',],


        ];
    }

    
}
