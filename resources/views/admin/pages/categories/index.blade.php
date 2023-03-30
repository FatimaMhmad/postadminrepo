@extends('admin.layout.app')
@section('title')
    AllCategorys
@endsection
@section('content')

    @auth
        <a class="btn btn-success" href="{{ route('category.create') }}" role="button">Create New Category</a>
    @endauth
    <br><br>
    <a class="btn btn-success"  href="/category/index/?sort=title"  role="button">Sort By Title</a>
    <a class="btn btn-success"  href="/category/index/?sort=-title"  role="button">Sort By Title inverse</a>

    <br><br>
        <form class="d-flex"  role="search" Method="GET">
            <input class="form-control me-x2" type="search"  name="filter[title]" placeholder="Filter Title"
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
            @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{ $category->id }}</th>
                    <td>{{ $category->title }}</td>
                    <td>
                        @auth
                            <a class="btn btn-primary" href="{{ route('category.edit', $category->id) }}" role="button">Edit</a>
                                @if ($category->posts_count <= 0)
                                    <a class="btn btn-primary" href="{{ route('category.destroy', $category->id) }}"
                                        role="button">Delete</a>
                                @endif
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
