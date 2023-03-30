<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return
        [
                'title' => 'nullable|max:50|min:5|string'
        ];
    }

    public function messages()
    {

        return
        [
            'title.max'       => 'لا يسمح اكثر من خمسين حرف',
            'title.min'       => 'لا يسمح اقل من خمسة احرف',
            'title.string'    => 'لا يسمح  بادخال رقم',
            'title.nullable'  => 'لم يتم تعديل البيانات البيانات هي نفسها القديمة'
        ];

    }
}
