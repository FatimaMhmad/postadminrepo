<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return
        [
            'title'=>'required|string|unique:categories|max:50|min:5'
        ];
    }

    public function messages()
    {
        return
        [
            'title.required' => 'العنوان مطلوب',
            'title.unique'   => ' هذه الفئة موجودة',
            'title.max'      => 'لا يسمح اكثر من خمسين حرف',
            'title.min'      => 'لا يسمح اقل من خمسة احرف',
            'title.String'    => 'لا يسمح  بادخال رقم',
        ];
    }
}
