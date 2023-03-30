<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Spatie\QueryBuilder\QueryBuilder;
use Database\Factories\CategoryFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {

       // $categories=CategoryResource::collection(Category::all());

        $categories = QueryBuilder::for(Category::class)
        ->allowedFilters([
            'title',
            ])
        ->allowedSorts('title')
        ->withCount('posts')
        ->get();

        $categories = CategoryResource::collection($categories);

        return $this->apiResponse($categories,'تم استرجاع البيانات بنجاح',200);
    }

    public function show($id)
    {
       // $category=CategoryResource::make(Category::find($id));

        $category=Category::find($id);

        if($category)
        {
            return  $this->apiResponse(CategoryResource::make($category),'تم استرجاع البيانات بنجاح',200);
        }
            return  $this->apiResponse(null,'هذه الفئة غير موجودة',404);
    }

    public function store(StoreCategoryRequest $request)
    {

        $category = Category::create($request->validated());

        if($category)
        {
            return $this->apiResponse(CategoryResource::make($category),'THE CATEGORY SAVE',201);
        }

            return $this->apiResponse(null,'THE CATEGORY NOT SAVE',400);
    }

    public function update(UpdateCategoryRequest $request,Category $category)
    {
        $category->update(array_filter($request->validated(), fn ($value) => !is_null($value)));

        if($category)
        {
            return $this->apiResponse(CategoryResource::make($category),'THE CATEGORY UPDATE',201);
        }

            return $this->apiResponse(null,'THE CATEGORY NOT FOUND',404);
    }

    public function destroy(Category $category)
    {
            $category->delete();
            
            return  $this->apiResponse(CategoryResource::make($category),'THE CATEGORY DELETED',200);

    }

}
