<nav class="navbar navbar-expand-lg bg-body-tertiary">

  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
        </li>
        @auth
        <li class="nav-item">
          <a class="nav-link" href="{{route('post.index')}}">YourPost</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('category.index')}}">Categorys</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('tag.index')}}">Tags</a>
        </li>
        @endauth
         <li class="nav-item">
          <a class="nav-link" href="{{route('post.publish')}}">Posts</a>
        </li>
      </ul>
    </div>
  </div>
   @auth
        <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
                @endauth
</nav>