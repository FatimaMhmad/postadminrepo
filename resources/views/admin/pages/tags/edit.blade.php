<h1>Edit Tag{{$tag->title}}</h1>
<form action="{{route('tag.update',$tag->id)}}" method="post"> 
    @csrf
    <input type="text"  class="@error('title') is-invalid @enderror" name="title" value="{{$tag->title}}"><br><br>
    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <button type="submit">Submit</button>
</form>