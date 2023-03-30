<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\Tag;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    public function index()
    {

        $categories = Category::get();
        $tags       = Tag::get();
        $user       = auth()->user();
        $posts      = $user->posts();
        
        $posts = QueryBuilder::for($posts)
        ->allowedFilters([
        AllowedFilter::exact('category_id'),
        'title',
        ])
        ->allowedSorts('title','date_of_publication')
        ->get();

         //  AllowedFilter::partial('tags.id','tags_ids')
        // if (request()->has('post_title')) {
        //     $posts->where('title', 'LIKE', '%' . request()->post_title . '%');

        // }
        // if (request()->has('tag_id')) {

        //     $tags_array = request()->tag_id;

        //     $posts->withWhereHas('tags', function ($q) use ($tags_array) {
        //         $q->whereIn('tags.id', $tags_array);
        //     })->get();

        //NO THIS BAD
        //     $posts->whereHas('tags', function ($q) use ($tags_array) {
        //         $q->whereIn('tags.id', $tags_array);
        //     });
        // }

        // $posts = $posts->get();

        return view(
            'admin.pages.posts.index',
            [
                'categories'     => $categories,
                'tags'           => $tags,
                'posts'          => $posts,
            ]
        );
    }
    public function create()
    {
        $categories = Category::get();

        $tags       = Tag::get();

        return view(
            'admin.pages.posts.create',
            [
                'categories'  => $categories,
                'tags'        => $tags
            ]
        );
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

        return redirect()->route('post.index');
    }
    public function show(Post $post)
    {
        //
    }
    public function edit(Post $post)
    {

        $categories = Category::get();

        $tags       = Tag::get();

        $file       = $post->getFirstMedia('post');

        $post->load('tags');

        if ($file != null)
        {
            $file_name  =  $file['file_name'];
        }
        else
        {
            $file_name = 'لا يوجد صورة لهذا البوست';
        }
        // dd($categories[0]['id']);

        return view(
            'admin.pages.posts.edit',
            [
                'post'       => $post,
                'categories' => $categories,
                'tags'       => $tags,
                'file_name'  => $file_name,
            ]
        );
    }
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update(array_filter($request->validated(), fn ($value) => !is_null($value)));

        if ($request->image != null) {
            $post->addMedia($request->image)->toMediaCollection('post');
        };

        $post->tags()->sync($request->tag_id);

        return redirect()->route('post.index');
    }


    public function delete(Post $post)
    {

        // {
        //     if ($post->getFirstMedia('post') != null)
        //     {
        //         // $items = $post->getFirstMedia('post');
        //         // $items->delete();

        //         $post->clearMediaCollection('post');
        //     }

        $post->delete();

        return redirect()->route('post.index');
    }

    public function publish()
    {

        //$posts = Post::get();


        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters([
            AllowedFilter::exact('category_id'),
            'title',
            ])
            ->allowedSorts('title','date_of_publication')
            ->where('date_of_publication', '<=', Carbon::now())
            ->where('date_of_publication', '>=', Carbon::now()->subDays(1))
            ->get();

        // $posts = Post::where('date_of_publication', '<=', Carbon::now())
        //     ->where('date_of_publication', '>=', Carbon::now()->subDays(1))->get();


        $categories = Category::get();
        $tags       = Tag::get();

        // if (request()->has('category_id')) {
        //     $posts->where('category_id', request()->category_id);
        // }
        // if (request()->has('post_title')) {
        //     $posts->where('title', 'LIKE', '%' . request()->post_title . '%');
        // }
        // if (request()->has('tag_id')) {
        //     $arr = request()->tag_id;
        //     $posts->whereHas(
        //         'tags',
        //         function ($q) use ($arr) {
        //             $q->whereIn('tags.id', $arr);
        //         }
        //     );
        // }
        return view(
            'user.index',

            [
                'categories'     => $categories,
                'tags'           => $tags,
                'posts'          => $posts,
            ]
        );
    }

    public function republishnow(Post $post)
    {
        $post->update([
            'date_of_publication' => Carbon::now()
        ]);

        return redirect()->route('post.index');
    }
}
