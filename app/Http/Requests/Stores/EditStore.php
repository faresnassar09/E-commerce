<?php

namespace App\Http\Requests\Stores;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditStore extends FormRequest
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
            'name' => ['required',
            'min:6',
            'max:100',
            Rule::unique('stores')->ignore($this->id), 
        ],
        
            'description' => ['required', 'string','min:10', 'max:120'],
            
                ];
    }

    public function messages(){
    
    return[
        'name.required' => 'الاسم مطلوب',
        'name.min' => 'يجب ان يكون الاسم 6 احرف علي الاقل',
        'name.unique' => 'هذا الاسم مستخدم من قبل',
        'name.regex' => 'يجب ان يكون الاسم احرف فقط',
        'description.min' => ' لا يجب ان يقل الوصف عن 10 احرف',
];

 }  

}
