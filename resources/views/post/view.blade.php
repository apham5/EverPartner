@extends('layouts.app')

@section('content')

<div class="row justify-content-between">
    <div class="col">
        <div class="row">
            <h1 class="col-md-auto">{{ $post->course->classname }}: {{ $post->assignment }} </h1>
            @if($post->status == 0)
                <span class="badge badge-danger col-md-auto align-self-center" style="font-size: 15px">Closed</span>
            @else
                <span class="badge badge-success col-md-auto align-self-center" style="font-size: 15px">Open</span>
            @endif
        </div>
    </div>
    <div class="col-md-auto">
    @if($self_post)
        <a class="btn btn-primary" href="{{ route('post.edit', $post)}}" role="button">Edit Post</a> 
    @else
        @if ($post->status == 1)
            @if (!$request_sent)
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Request to Join</button>
            @else
                <button type="button" class="btn btn-primary" disabled>Request Sent</button>
            @endif
        @else
            <button type="button" class="btn btn-primary" disabled>Post Closed</button>
        @endif
    @endif
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Create Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="new_req" method="POST" action="{{ route( 'grouprequest.store') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <div class="form-group">
                        <p>Attach a note explaining why you would like to join.</p>
                        <textarea 
                            form="new_req"
                            class="form-control" name="content" id="content" rows="5"
                            placeholder="How does your plan/vision coincide with that of the poster? What skills do you have that can help the group?" >
                        </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<h5>Posted by <a href="{{ route('user.show', $post->poster_id) }}">{{ $post->user->firstname }} {{ $post->user->lastname }}</a> at {{ $post->created_at }}</h5>

<h5>Looking for: <b>{{ $post->partner_num }}</b> group member(s).</h5>

<h5 class="text-muted">{{ $post->content }}</h6>

<hr>

<h3>Follow-up Questions</h3>
@if(count($post->comments) == 0)
    <p><i>There currently aren't any follow-up questions to this post.</i></p>
@else
    @foreach($post->comments as $comment)
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col">
                    <h5 class="card-title">{{ $comment->user->firstname }} {{ $comment->user->lastname }} </h5>
                </div>
                <div class="col-md-auto">
                    <p class="card-text">{{ $comment->created_at }}</p>
                </div>
            </div>
            <h5 class="card-text text-muted">{{ $comment->content }}</h5>
        </div>
    </div>
    @endforeach
@endif

<form id="comment" method="POST" action="{{ route('comment.store') }}">
    @csrf
    <h3>Ask a follow-up question:</h3>
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <textarea 
        form="comment"
        class="form-control" name="content" id="content" rows="2"
        placeholder="What do you want to know?" 
        style="margin-bottom: 8px">
    </textarea>
    <button type="submit" class="btn btn-primary float-right">Submit</button>
</form>
@endsection