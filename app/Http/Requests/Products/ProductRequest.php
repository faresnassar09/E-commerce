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

    'discount' =>    ['max:150'],
    'name' =>        ['required','min:6','max:255','unique:products'],
    'description' => ['required','min:10','max:1000'],
    'price' =>       ['numeric','min:0.1','max:10000'],
    'quantity' =>    ['numeric','min:1','max:1000'],
    'quantity' =>    ['numeric','min:1','max:1000'],
    'category_id' => ['required'],
    'images.*' =>    ['required','mimes:jpeg,png,jpg,gif,svg','max:2048',],


        ];
    }

    public function messages(): array
    {
        return [
            'discount.max' => 'الخصم كبير جداً، يرجى مراجعة الدعم.',
    
            'name.required' => 'يجب إدخال اسم للمنتج.',
            'name.min' => 'اسم المنتج يجب أن يحتوي على 6 أحرف على الأقل.',
            'name.max' => 'يجب ألا يتجاوز اسم المنتج 255 حرفاً.',
            'name.unique' => 'هذا الاسم موجود بالفعل، اختر اسماً آخر أو أضف أي تغيير.',
    
            'description.required' => 'يجب إدخال وصف للمنتج.',
            'description.min' => 'الوصف يجب أن يكون 10 أحرف على الأقل.',
            'description.max' => 'الوصف طويل جداً، قلّص عدد الأحرف إلى 1000 كحد أقصى.',
    
            'price.numeric' => 'يجب أن يكون السعر رقماً.',
            'price.min' => 'السعر لا يمكن أن يكون أقل من 0.1.',
            'price.max' => 'السعر لا يمكن أن يتجاوز 10000.',
    
            'quantity.numeric' => 'يجب أن تكون الكمية رقماً.',
            'quantity.min' => 'يجب أن تكون الكمية على الأقل 1.',
            'quantity.max' => 'أقصى كمية مسموح بها هي 1000.',
    
            'category_id.required' => 'يجب اختيار فئة للمنتج.',
    
            'images.*.required' => 'يجب اختيار صورة واحدة على الأقل.',
            'images.*.mimes' => 'نوع الصورة غير مدعوم. الأنواع المسموح بها: jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميغابايت.',
        ];
    }
    
}
