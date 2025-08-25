<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
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
            'subject' => ['required','min:5','max:30'],
            'details' => ['required','min:10','max:255'],
            'images.*' => ['nullable','image', 'mimes:jpg,png,jpeg','max:1024'],  
        
        ];
    }
}
