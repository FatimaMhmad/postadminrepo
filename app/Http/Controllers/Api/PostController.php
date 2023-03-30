<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostTag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;



class PostController extends Controller
{

    use ApiResponseTrait;

    public function index()
    {

        $user       = auth()->user();

        $posts      = $user->posts();

        $posts = QueryBuilder::for($posts)
        ->allowedFilters([
        AllowedFilter::exact('category_id'),
        'title',
        ])
        ->allowedSorts('title','date_of_publication')
        ->get();

        $posts=PostResource::collection($posts);

        return $this->apiResponse($posts,'تم استرجاع البيانات بنجاح',200);

    }

    public function store(StorePostRequest $request)
    {
        $request->merge([
            'user_id' => auth()->user()->id
        ]);

        $post = Post::create($request->validated());

        if ($request->image != null)
        {
            $post->addMedia($request->image)->toMediaCollection('post');
        }

        $tags_added_to_post = $request->tag_id;

        if ($tags_added_to_post != null)
        {
            foreach ($tags_added_to_post as $tag_id)
            {
                PostTag::create([
                    'post_id'    => $post->id,
                    'tag_id'     => $tag_id,
                ]);
            }
        }

        if($post)
        {
            return $this->apiResponse(PostResource::make($post),'THE  POST SAVE',201);
        }

            return $this->apiResponse(null,'THE POST NOT SAVE',400);

    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update(array_filter($request->validated(), fn ($value) => !is_null($value)));

        if ($request->image != null)
        {
            $post->addMedia($request->image)->toMediaCollection('post');
        };

        $post->tags()->sync($request->tag_id);

        if($post)
        {
            return $this->apiResponse(PostResource::make($post),'THE POST UPDATE',201);
        }

            return $this->apiResponse(null,'THE POST NOT FOUND',404);
    }

    public function destroy(Post $post)
    {
            $post->delete();

            return  $this->apiResponse(PostResource::make($post),'THE POST DELETED',200);

    }

    public function publish()
    {
        $posts = QueryBuilder::for(Post::class)
        ->allowedFilters([
        AllowedFilter::exact('category_id'),
        'title',
        ])
        ->allowedSorts('title','date_of_publication')
        ->where('date_of_publication', '<=', Carbon::now())
        ->where('date_of_publication', '>=', Carbon::now()->subDays(1))
        ->get();

        $posts=PostResource::collection($posts);

        return $this->apiResponse($posts,'تم استرجاع البيانات بنجاح',200);

    }

    public function republishnow(Post $post)
    {
        $post->update([
            'date_of_publication' => Carbon::now()
        ]);

        if($post)
        {
            return $this->apiResponse(PostResource::make($post),'THE POST REPUBLISH',201);
        }

            return $this->apiResponse(null,'THE POST NOT FOUND',404);

    }

}
