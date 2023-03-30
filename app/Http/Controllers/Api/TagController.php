<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $tags=QueryBuilder::for(Tag::class)
        ->allowedFilters([
            'title',
        ])
        ->allowedSorts('title')
        ->withCount('posts')
        ->get();

        $tags=TagResource::collection($tags);

        return $this->apiResponse($tags,'تم استرجاع البيانات بنجاح',200);
        
    }

    public function store(StoreTagRequest $request)
    {

        $tag = Tag::create($request->validated());

        if($tag)
        {
            return $this->apiResponse(TagResource::make($tag),'THE TAG SAVE',201);
        }

            return $this->apiResponse(null,'THE TAG NOT SAVE',400);
    }

    public function update(UpdateTagRequest $request,Tag $tag)
    {
        $tag->update(array_filter($request->validated(), fn ($value) => !is_null($value)));

        if($tag)
        {
            return $this->apiResponse(TagResource::make($tag),'THE TAG UPDATE',201);
        }

            return $this->apiResponse(null,'THE TAG NOT FOUND',404);
    }

    public function destroy(Tag $tag)
    {
            $tag->delete();

            return  $this->apiResponse(TagResource::make($tag),'THE TAG DELETED',200);

    }
}
