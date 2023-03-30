
@extends('admin.layout.app')
@section('title')
AllTags
@endsection
@section('content')
@auth
    <a class="btn btn-success" href="{{route('tag.create')}}" role="button">Create New Tag</a>
@endauth
<br><br>
<a class="btn btn-success"  href="/tag/index/?sort=title"  role="button">Sort By Title</a>
<a class="btn btn-success"  href="/category/index/?sort=-title"  role="button">Sort By Title inverse</a>

<br><br>
    <form class="d-flex"  role="search" Method="GET">
        <input class="form-control me-2" type="search"  name="filter[title]" placeholder="Filter Title"
            aria-label="Search">
        <button class="btn btn-outline-success"  type="submit">Search</button>
    </form>

    <table class="table">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        @auth
        <th scope="col">Pro</th>
        @endauth
        </tr>
    </thead>
    <tbody>
        @foreach($tags as $tag)
        <tr>
        <th scope="row">{{$tag->id}}</th>
        <td>{{$tag->title}}</td>
        <td>
        @auth
        <a class="btn btn-primary" href="{{route('tag.edit',$tag->id)}}" role="button">Edit</a>

        @if ($tag->posts_count <= 0)
                <a class="btn btn-primary" href="{{route('tag.destroy',$tag->id)}}" role="button">Delete</a>
            @endif

        @endauth
        </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
