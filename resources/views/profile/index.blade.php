@extends('templates.default')

@section('content')
<br>
    <div class="row">
        <div class="col-lg-6">
            @include('user.partials.userblock')
            <hr>
            
            @if (!$statuses->count())
                <p>{{ $user->getFirstNameOrUsername }} hasn't posted anything yet.</p>
            @else
                @foreach ($statuses as $status)
                    <div class="media">
                        <a href="{{ route('profile.index', ['username' => $status->user->username]) }}" class="pull-left">
                            <img src="{{ $status->user->getAvatarUrl() }}" alt="{{ $status->user->getNameOrUsername() }}" class="media-object">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
                            <p>{{ $status->body }}</p>
                            <ul class="list-inline">
                                <li class="list-inline-item">{{ $status->created_at->diffForHumans() }}</li>
                                @if ($status->user->id !== Auth::user()->id)
                                    <li class="list-inline-item"><a href="{{ route('status.like', ['statusId' => $status->id]) }}">Like</a></li>
                                @endif
                                <li class="list-inline-item">{{ $status->likes->count() }} {{ str_plural('Like', $status->likes->count()) }}</li>
                            </ul>

                            @foreach ($status->replies as $reply)
                                <div class="media">
                                    <a href="{{ route('profile.index', ['username' => $reply->user->username]) }}" class="pull-left">
                                        <img src="{{ $reply->user->getAvatarUrl() }}" alt="{{ $reply->user->getNameOrUsername() }}" class="media-object">
                                    </a>
                                    <div class="media-body">
                                        <h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
                                        <p>{{ $reply->body }}</p>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">{{ $reply->created_at->diffForHumans() }}</li>
                                            @if ($reply->user->id !== Auth::user()->id)
                                                <li class="list-inline-item"><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">Like</a></li>
                                            @endif
                                            <li class="list-inline-item">{{ $reply->likes->count() }} {{ str_plural('Like', $reply->likes->count()) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if ($authUserIsFriend || Auth::user()->id == $status->user->id)
                            <form role="form" action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post">
                                <div class="form-group{{ $errors->has('reply-{$status->id}') ? ' has-error': '' }}">
                                    <textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
                                    @if ($errors->has("reply-{$status->id}"))
                                        <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
                                    @endif
                                </div>
                                    <input type="submit" value="Reply" class="btn btn-outline-primary btn-sm">
                                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                            </form>
                            @endif
                        </div>
                    </div>
                @endforeach

            @endif

        </div>
        <div class="col-lg-6 col-lg-offset-6">
            <br>
            @if (Auth::user()->hasFriendRequestPending($user))
                <p>Waiting for {{ $user->getNameOrUsername() }} to accept your request.</p>
            @elseif (Auth::user()->hasFriendRequestReceived($user))
                <a href="{{ route('friends.accept', ['username' => $user->username]) }}" class="btn btn-primary">Accept friend request</a>
            @elseif (Auth::user()->isFriendsWith($user))
                <p>You and {{ $user->getNameOrUsername() }} are friends.</p>

                <form action="{{ route('friends.delete', ['username' => $user->username]) }}" method="post">
                    <input class="btn btn-danger" type="submit" value="Remove friend">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>

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