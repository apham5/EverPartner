@extends('layouts.app')

@section('content')
<h1>Edit Post</h1>
<form id="edit_post" method="POST" action="{{ route('post.update', $post) }}">
    @csrf
    @method('PUT')

    <h3>Status</h3>
    <p>Are you still looking for group members?</b>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="open" value="1" checked>
        <label class="form-check-label" for="open">
            Yes
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="closed" value="0">
        <label class="form-check-label" for="closed">
            No
        </label>
    </div>

    <h3>Assignment</h3>
    <input type="text" class="form-control" name="assignment" placeholder="What assignment is this post for?" value="{{ $post->assignment }}">

    <h3>Number of group members</h3>
    <input type="number" class="form-control" name="partner_num" placeholder="How many group members are you looking for?" value="{{ $post->partner_num }}">

    <h3>Details</h3>
    <textarea 
        form="edit_post"
        class="form-control" name="content" id="content" rows="6"
        placeholder="What are your project ideas? What are you looking for in your partners? How do you plan to do this project?">{{ $post->content }}</textarea>
    <br/>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a class="btn btn-secondary" href="{{ route('user.show', Auth::user()) }}">Back</a>
</form>

<!-- stuff for the tags input -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js">
</script>
<link href="{{ asset('css/taginput.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">
@endsection
