<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\Http\Request;

class Category_unique
{
    public function handle(Request $request, Closure $next)
    {
        $categories=Category::get();
        foreach($categories as $category){
            if($request->title == $category->title){
                return response('الفئة موجودة مسبقا');
            }
        }
        return $next($request);
    }
}
