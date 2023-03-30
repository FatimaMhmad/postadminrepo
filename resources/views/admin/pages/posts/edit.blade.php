@inject('carbon', 'Carbon\Carbon')
@extends('admin.layout.app')
@section('title')
    Edit Post
@endsection
@section('content')
    <form class='container' action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="file" value="" name="image"><br><br>
        <p>{{ $file_name }}</p>
        <input type="text" class="@error('title') is-invalid @enderror" name="title" value="{{ $post->title }}"><br><br>
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="text" class="@error('body') is-invalid @enderror"name="body" value="{{ $post->body }}"><br><br>
        @error('body')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @if ($post->date_of_publication < $carbon::now()->subDays(1) || $post->date_of_publication > $carbon::now())
            <input type="datetime-local"
                class="@error('date_of_publication') is-invalid @enderror"name="date_of_publication"
                value="{{ $post->date_of_publication }}"><br><br>
            @error('date_of_publication')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        @endif

        <select class="form-select" name="ctegory_id" aria-label="Default select example">
            <option value="">
                اختر فئة
            </option>
            @foreach ($categories as $category)
                <option @if ($category['id'] == $post->category_id) @selected ($category['title'])
                    @endif
                    value="{{ $category['id'] }}">{{ $category['title'] }}</option>
            @endforeach
        </select>
        {{-- check tag --}}
        <li>
            <form Method="GET">
                <select class="js-example-basic-multiple" name="tag_id[]" multiple="multiple">
                    <option value="">
                        اختر تاغ
                    </option>
                    @foreach ($tags as $tag)
                        <option
                            @foreach ($post->tags as $post_tag)
                                        @if ($tag['id'] == $post_tag['id'])
                                            @selected($tag['title'])
                                        @endif @endforeach
                            value={{ $tag['id'] }}>
                            {{ $tag['title'] }}
                        </option>
                    @endforeach
                </select>
        </li>
        <button type="submit">Submit</button>
    </form>
@endsection
