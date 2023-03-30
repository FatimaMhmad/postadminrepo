<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory ,InteractsWithMedia;
    protected $fillable =
    [
        'title',
        'body',
        'date_of_publication',
        'category_id',
        'user_id'
    ];
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'post_tag');
    }
    public function registerMediaCollections(): void
    {
        $this
        ->addMediaCollection('post')->singleFile();
    }
}
