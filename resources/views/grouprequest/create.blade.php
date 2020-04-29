@extends('layouts.app')

@section('content')

<h1>Request to Join</h1>
<form id="new_req" method="POST" action="{{ route( 'grouprequest.store') }}">
    @csrf

    <input type="hidden" name="post_id" value="{{ $post_id }}">

    <p>Attach a note explaining why you would like to join.</p>
    <textarea 
        form="new_req"
        class="form-control" name="content" id="content" rows="5"
        placeholder="How does your plan/vision coincide with that of the poster? What skills do you have that can help the group?" >
    </textarea>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>


@endsection