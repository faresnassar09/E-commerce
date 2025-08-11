<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintReplyRequest extends FormRequest
{
 
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [


                'message' =>['required','min:5','max:255'],
                'images.*' =>['nullable','max:1024','mimes:png,jpg,jpge'],
               

        ];
    }
}
