@extends('templates.default')

@section('content')
    <br>
    <div class="row">
        <div class="col-lg-8">
            <form role="form" action="{{ route('status.post') }}" method="post">
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <textarea placeholder="What's up {{ Auth::user()->getFirstNameOrUsername() }}?" name="status" class="form-control" rows="2"></textarea>
                    @if ($errors->has('status'))
                        <span class="help-block">{{ $errors->first('status') }}</span>
                    @endif
                    <br>
                    <button type="submit" class="btn btn-outline-primary">Update status</button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </div>
            </form>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            @if (!$statuses->count())
                <p>There's nothing in your timeline, yet.</p>
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
                        </div>
                    </div>
                @endforeach

                {!! $statuses->render() !!}
            @endif
        </div>
    </div>
@stop