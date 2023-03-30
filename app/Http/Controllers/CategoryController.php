<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Post;
use Spatie\QueryBuilder\QueryBuilder;


class CategoryController extends Controller
{

    public function index()
    {
       // $categories = Category::withCount('posts')->get();

        $categories=QueryBuilder::for(Category::class)
        ->allowedFilters([
            'title',
        ])
        ->allowedSorts('title')
        ->withCount('posts')
        ->get();

        return view(
            'admin.pages.categories.index',
            [
                'categories'              => $categories,
            ]
        );
    }

    public function create()
    {
        return view('admin.pages.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('category.index');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        return view(
            'admin.pages.categories.edit',
            [
                'category' => $category
            ]
        );
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $category->update(array_filter($request->validated(), fn ($value) => !is_null($value)));

        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index');
    }
}
