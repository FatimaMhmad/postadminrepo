<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return
        [
            'title'                 =>'required|max:50|min:5|string',
            'body'                  =>'required|max:250|min:20|string',
            'date_of_publication'   =>'required|date|after:now',
            'category_id'           =>'required|numeric',
        ];

    }
    public function messages()
    {
        return
        [
            'title.required'                   => 'العنوان مطلوب',
            'title.max'                        => 'لا يسمح اكثر من خمسين حرف',
            'title.min'                        => 'لا يسمح اقل من خمسة حرف',
            'title.string'                        => 'لا يسمح ادخال رقم',
            'body.required'                    =>'هذا الحقل مطلوب',
            'body.max'                           => 'لا يسمح اكثر من مئتان وخمسين حرف',
            'body.min'                           => 'لا يسمح اقل من عشرين حرف',
            'body.string'                        => 'لا يسمح ادخال رقم',
            'date_of_publication.required'    =>'رجاء قم بتحديد تاريخ النشر',
            'date_of_publication.date'        =>'ادخل تاريخ مناسب',
            'category_id.required'            =>'قم باختيار فئة لهذا البوست'
        ];
    }
    public function validated($key = null, $default = null)
    {

        return
        [
            'title'                 =>$this->title,
            'body'                  =>$this->body,
            'date_of_publication'   =>$this->date_of_publication,
            'category_id'           =>$this->category_id,
            'user_id'               =>$this->user_id
        ];
    }

}
