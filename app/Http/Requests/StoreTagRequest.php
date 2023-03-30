<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return
        [
            'title'=>'required|unique:tags|max:50|min:5|string'
        ];
    }
    public function messages()
    {
        return
        [
            'title.required' => 'العنوان مطلوب',
            'title.max'      => 'لا يسمح اكثر من خمسين حرف',
            'title.unique'   => ' هذه الفئة موجودة',
            'title.min'      => 'لا يسمح اقل من خمسة احرف',
            'title.string'    => 'لا يسمح  بادخال رقم',
        ];
    }
}
