<?php

namespace App\Http\Requests\Stores;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required',
            'min:6',
            'max:100',
            Rule::unique('stores')->ignore($this->route('store')), 
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
