<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $data = [
            'title'                 => 'nullable|max:50|min:5|string',
            'body'                  => 'nullable|max:250|min:20|string',
            'date_of_publication'   => 'nullable|date|after:now',
            'category_id'           => 'nullable'
        ];

        return $data;
    }


    public function messages()
    {
        return
            [
                'title.max'                        => 'لا يسمح اكثر من خمسين حرف',
                'title.min'                        => 'لا يسمح اقل من خمسة حرف',
                'title.string'                        => 'لا يسمح ادخال رقم',
                'body.max'                           => 'لا يسمح اكثر من مئتان وخمسين حرف',
                'body.min'                           => 'لا يسمح اقل من عشرين حرف',
                'body.string'                        => 'لا يسمح ادخال رقم',
                'date_of_publication.required'    => 'رجاء قم بتحديد تاريخ النشر',
                'date_of_publication.date'        => 'ادخل تاريخ مناسب'
            ];
    }

    public function validated($key = null, $default = null)
    {
        return
        [
            'title'                 =>$this->title,
            'body'                  =>$this->body,
            'date_of_publication'   =>$this->date_of_publication,
            'category_id'           =>$this->ctegory_id,
        ];
    }
}
