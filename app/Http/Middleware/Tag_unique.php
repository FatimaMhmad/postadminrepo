<?php

namespace App\Http\Middleware;

use App\Models\Tag;
use Closure;
use Illuminate\Http\Request;

class Tag_unique
{
    public function handle(Request $request, Closure $next)
    {
        $tags=Tag::get();
        foreach($tags as $tag){
            if($request->title == $tag->title){
                return response('التاغ موجودة مسبقا');
            }
        }
        return $next($request);
    }
}
