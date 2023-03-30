<h1>Create New Category</h1>
<form action="{{route('category.store')}}" method="post"> 
    @csrf
    <input type="text" class="@error('title') is-invalid @enderror" value="{{old('title')}}" name="title" placeholder="Enter title">
    <br><br>
    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <button type="submit">Submit</button>
</form>