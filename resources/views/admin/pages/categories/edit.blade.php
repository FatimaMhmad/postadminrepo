<h1>Edit Category{{$category->title}}</h1>
<form action="{{route('category.update',$category->id)}}" method="post">
    @csrf
    <input type="text"  class="@error('title') is-invalid @enderror"  name="title" value="{{$category->title}}"><br><br>
    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <button type="submit">Submit</button>
</form>
