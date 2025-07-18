<?php

namespace App\Http\Requests\Stores;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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

            'name' => ['required', 'string', 'min:5','max:100','unique:stores'],
            'description' => ['required', 'string','min:10', 'max:120'],
        
        
            'images.*' => [
                'nullable', 
                'mimes:jpeg,png,jpg,gif,svg',   
                'max:2048',
            ],



        ];
    }


    public function messages(): array
    {


return[

    'name.unique' => 'هذا الاسم محجوز',
    'name.min' => 'يجب ان يكون الاسم علي الاقل 5 احرف',
    'description.min' => 'الحد الادني لوصف المتجر 10 احرف', 
 ];

    }
}
