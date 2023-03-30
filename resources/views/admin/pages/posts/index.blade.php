@inject('carbon', 'Carbon\Carbon')
    @extends('admin.layout.app')
    @section('title')
        AllPosts
    @endsection
    @section('content')
        <div class='container'>
            <ul class="nav nav-tabs">

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/post/index">posts</a>
                </li>

                <li>
                    <form Method="GET">
                        <select name="filter[category_id]" onChange="form.submit()">
                            <option value="">
                                اختر فئة
                            </option>
                            @foreach ($categories as $category)
                                <option  @if (isset(request()->filter['category_id']) && request()->filter['category_id'] == $category->id) selected @endif  value={{ $category->id }}>
                                    {{ $category->title }}

                                </option>
                            @endforeach
                        </select>
                    </form>
                </li>

                {{-- check tag --}}
                <li>

                    <form Method="GET">

                        <select class="js-example-basic-multiple" name="tag_id[]"  multiple="multiple" >
                            <option value="">
                                اختر تاغ
                            </option>
                            @foreach ($tags as $tag)
                                <option value={{$tag->id}}>
                                    {{ $tag->title }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary" onChange="form.submit()">ok</button>
                    </form>
                </li>


                <li>
                    <form class="d-flex"  role="search" Method="GET">
                        <input class="form-control me-2" type="search"  name="filter[title]" placeholder="Search Title"
                            aria-label="Search">
                        <button class="btn btn-outline-success"  type="submit">Search</button>
                    </form>
                </li>
            </ul>
            @auth
                <a class="btn btn-success" href="{{ route('post.create') }}" role="button">Create New Post</a>
            @endauth
          <br> <br >
            <a class="btn btn-success" href="/post/index/?sort=title" role="button">Sort By Title</a>
            <a class="btn btn-success" href="/post/index/?sort=-title" role="button">Sort By Title inverse</a>

            <a class="btn btn-success" href="/post/index/?sort=date_of_publication" role="button">Sort By Date_of_publication</a>
            <a class="btn btn-success" href="/post/index/?sort=-date_of_publication" role="button">Sort By Date_of_publication inverse</a><br><br>

                @if( $posts != null)
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card" >
                            <img src="{{$post->getFirstMediaUrl('post')}}"   class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">  {{ $post->body }}</p>
                                    <p class="card-text"> {{ $post->date_of_publication }}</p>
                                @auth
                                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                                        @if( $post->date_of_publication < $carbon::now()->subDays(1) || $post->date_of_publication > $carbon::now())
                                        <a href="{{ route('post.republishnow', $post->id) }}" class="btn btn-primary">republishNow</a>
                                            @endif
                                    <a href ="   {{ route('post.delete', $post->id) }}" class="btn btn-primary">Delete</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
                @endif
        </div>
    @endsection
