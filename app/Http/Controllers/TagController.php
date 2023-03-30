<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends Controller
{
    public function index()
    {
         // $tag_id_not_used = Tag::doesntHave('posts')
        // ->pluck('id')->toArray();

        //this
        //$tags = Tag::withCount('posts')->get();
        
        $tags=QueryBuilder::for(Tag::class)
        ->allowedFilters([
            'title',
        ])
        ->allowedSorts('title')
        ->withCount('posts')
        ->get();

        return view('admin.pages.tags.index',
        [
            'tags'               =>  $tags,
        ]);
    }
    public function create()
    {
        return view('admin.pages.tags.create');
    }
    public function store(StoreTagRequest $request)
    {
        Tag::create($request->validated());

        return redirect()->route('tag.index');
    }
    public function show(Tag $tag)
    {
        //
    }
    public function edit(Tag $tag)
    {
        return view('admin.pages.tags.edit',
        [
            'tag'=>$tag
        ]);
    }
    public function update(UpdateTagRequest $request,Tag $tag)
    {
        $tag->update($request->validated());

        return redirect()->route('tag.index');
    }
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tag.index');
    }
}
