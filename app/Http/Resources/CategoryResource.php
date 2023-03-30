<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray($request)
    {
       // dd($this);
        return
        [
            'id'    =>    $this->id,
            'title' =>    $this->title
        ];
    }
}
