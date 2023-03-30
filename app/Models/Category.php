<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'title'
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    // public function scopeTitleNotNull($query)
    // {
    //     return $query->whereNotNull('title');
    // }
}
