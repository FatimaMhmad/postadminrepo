   @extends('admin.layout.app')
   @section('title')
       Create New Post
   @endsection
   @section('content')
        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file"  name="image"><br><br>
            <input type="text" class="@error('title') is-invalid @enderror" value="{{old('title')}}" name="title" placeholder="Enter title"><br><br>
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" class="@error('body') is-invalid @enderror" value="{{old('body')}}" name="body" placeholder="Enter body"><br><br>
            @error('body')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="datetime-local" class="@error('date_of_publication') is-invalid @enderror" value="{{old('date_of_publication')}}"name="date_of_publication"><br><br>
                @error('date_of_publication')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <select class="@error('category_id') is-invalid @enderror" value="{{old('category_id')}}" class="form-select" name="category_id" aria-label="Default select example">
            <option value="">
            اختر فئة
            </option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" > {{ $category->title }} </option>
                @endforeach
            </select>
            <br><br>
            @error('ctegory_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            {{-- tag select --}}
            <select multiple  name ="tag_id[]" class="js-example-basic-multiple">
            <option value="">
            اختر تاغ
            </option>
                @foreach ($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                @endforeach
            </select>
            <br><br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    @endsection
