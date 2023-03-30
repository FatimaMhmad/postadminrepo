<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
   
    public function toArray($request)
    {
        return
        [
            'id'                  => $this->id,
            'title'               => $this->title,
            'body'                => $this->body,
            'date_of_publication' => $this->date_of_publication,
            'category_id'         => $this->category_id,
            'user_id'             => $this->user_id
        ];
    }
}
