@extends('layouts.app')

@section('content')
<h1>Your posts</h1>
@foreach($posts as $post)
    <div class="card">
        <div class="card-header">
            {{ $post->course->classname }}: {{ $post->assignment }}
        </div>
        <div class="card-body">
            @if($post->created_at == $post->updated_at)
                <p class="card-text">Created at {{ $post->created_at }}</p>
            @else
                <p class="card-text">Updated at {{ $post->updated_at }}</p>
            @endif
            @if($post->status == 1)
                <p class="card-text">Status: <span class="badge badge-success">Open</span></p>
            @else
                <p class="card-text">Status: <span class="badge badge-danger">Closed</span></p>
            @endif
            <p class="card-text">Looking for {{ $post->partner_num }} group member(s).</p>
            <a href="{{ route('post.show', $post) }}" class="stretched-link float-right">Details</a>
        </div>
    </div>
@endforeach
@endsection