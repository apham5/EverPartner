@extends('layouts.app')

@section('content')
<h1>Create Post in {{ $coursename }}</h1>

<form id="new_post" method="POST" action="{{ route( 'post.store') }}">
    @csrf

    <input type="hidden" name="class_id" value="{{ $class_id }}">

    <h3>Assignment</h3>
    <input type="text" class="form-control" name="assignment" placeholder="What assignment is this post for?">

    <h3>Number of group members</h3>
    <input type="number" class="form-control" name="partner_num" placeholder="How many group members are you looking for?">

    <h3>Details</h3>
    <textarea 
        form="new_post"
        class="form-control" name="content" id="content" rows="6"
        placeholder="What are your project ideas? What are you looking for in your partners? How do you plan to do this project?" >
    </textarea>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a class="btn btn-secondary" href="{{ route('home') }}">Back</a> 
</form>

@endsection