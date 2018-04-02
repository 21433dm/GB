<nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand">Greenbook</a>
        </div>
        <div class="collapse navbar-collapse">
            @if (Auth::check())
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Timeline</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('friends.index') }}">Friends</a></li>
            </ul>
            
            <form action="{{ route('search.results') }}" role="search" class="form-inline">
                <div class="form-group">
                    <input type="text" name="query" class="form-control mr-sm-2" 
                    placeholder="Find people"/>
                </div>
                <button type="submit" class="btn btn-outline-primary my-2 my-sm-0">Search</button>
            </form>
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile.index', ['username' => Auth::user()->username]) }}">{{ Auth::user()->getNameOrUsername() }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Update profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('auth.signout') }}">Sign out</a></li>
                @else
                <form class="form-inline">    
                    <a class="btn btn-outline-primary mr-sm-2" href="{{ route('auth.signup') }}">Sign up</a>
                    <a class="btn btn-outline-primary my-2 my-sm-0" href="{{ route('auth.signin') }}">Sign in</a>
                </form>
                @endif
            </ul>
        </div>
    </div>
</nav>