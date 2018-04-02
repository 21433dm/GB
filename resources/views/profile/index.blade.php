@extends('templates.default')

@section('content')
<br>
    <div class="row">
        <div class="col-lg-6">
            @include('user.partials.userblock')
            <hr>
        </div>
        <div class="col-lg-6 col-lg-offset-6">
            <br>
            @if (Auth::user()->hasFriendRequestPending($user))
                <p>Waiting for {{ $user->getNameOrUsername() }} to accept your request.</p>
            @elseif (Auth::user()->hasFriendRequestReceived($user))
                <a href="{{ route('friends.accept', ['username' => $user->username]) }}" class="btn btn-primary">Accept friend request</a>
            @elseif (Auth::user()->isFriendsWith($user))
                <p>You and {{ $user->getNameOrUsername() }} are friends.</p>
            @elseif (Auth::user()->id !== $user->id)
                <a href="{{ route('friends.add', ['username' => $user->username]) }}" class="btn btn-primary">Add as friend</a>
            @endif

            <h4>{{ $user->getFirstNameOrUsername() }}'s friends.</h4>

            @if (!$user->friends()->count())
                <p>{{ $user->getFirstNameOrUsername() }} has no friends yet.</p>
            @else
                @foreach ($user->friends() as $user)
                    @include('user.partials.userblock')
                @endforeach
            @endif
        </div> 
    </div>
@stop