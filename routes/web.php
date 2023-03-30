<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

    Route::get('/', function ()
    {
        // $result=QueryBuilder::for(Category::class)
        // ->allowedFilters([
        // AllowedFilter::exact('id'),
        // 'title',
        // AllowedFilter::scope('titlenotnull')])
        // ->allowedSorts('title')
        // ->allowedFields(['id', 'title'])

        // ->get();
        // return $result;
        //dd($result);
        return view('welcome');
    });

    Route::get('/dashboard', function ()
    {
        return    view        ('admin.layout.app'  );
    })          ->middleware  (['auth', 'verified'])
                ->name        ('dashboard'         );

    Route::middleware('auth')->group(function ()
    {
        Route::get   ('/profile', [ProfileController::class, 'edit'   ])->name('profile.edit'   );
        Route::patch ('/profile', [ProfileController::class, 'update' ])->name('profile.update' );
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
    Route::get ('/home',                  [HomeController::class,'home'])        ->name('home')             ->middleware('auth');
    //categorys
    Route::get ('/category/index',        [CategoryController::class,'index'])   ->name('category.index')   ->middleware('auth');
    Route::get ('/category/create',       [CategoryController::class,'create'])  ->name('category.create')  ->middleware('auth');
    Route::post('/category/store',        [CategoryController::class,'store'])   ->name('category.store')   ->middleware('auth');
    Route::get ('/category/destroy/{category}', [CategoryController::class,'destroy']) ->name('category.destroy') ->middleware('auth');
    Route::get ('/category/edit/{category}',[CategoryController::class,'edit'])    ->name('category.edit')    ->middleware('auth');
    Route::post('/category/update/{category}',  [CategoryController::class,'update'])  ->name('category.update')  ->middleware('auth');
    //tags
    Route::get ('/tag/index',              [TagController::class,'index'])        ->name('tag.index')        ->middleware('auth');
    Route::get ('/tag/create',             [TagController::class,'create'])       ->name('tag.create')       ->middleware('auth');
    Route::post('/tag/store',              [TagController::class,'store'])        ->name('tag.store')        ->middleware('auth');
    Route::get ('/tag/destroy/{tag}',      [TagController::class,'destroy'])      ->name('tag.destroy')      ->middleware('auth');
    Route::get ('/tag/edit/{tag}',         [TagController::class,'edit'])         ->name('tag.edit')         ->middleware('auth');
    Route::post('/tag/update/{tag}',       [TagController::class,'update'])       ->name('tag.update')       ->middleware('auth');
    //posts
    Route::get ('/post/index',             [PostController::class,'index'])       ->name('post.index')       ->middleware('auth');
    Route::get ('/post/create',            [PostController::class,'create'])      ->name('post.create')      ->middleware('auth');
    Route::post('/post/store',             [PostController::class,'store'])       ->name('post.store')       ->middleware('auth');
    Route::get ('/post/edit/{post}',       [PostController::class,'edit'])        ->name('post.edit')        ->middleware('auth');
    Route::put ('/post/update/{post}',     [PostController::class,'update'])      ->name('post.update')      ->middleware('auth');
    Route::get ('/post/delete/{post}',     [PostController::class,'delete'])      ->name('post.delete')      ->middleware('auth');
    //publishpost
    Route::get ('/post/publish',            [PostController::class,'publish'])     ->name('post.publish');
    Route::get ('/post/republishnow/{post}',[PostController::class,'republishnow'])->name('post.republishnow')->middleware('auth');
