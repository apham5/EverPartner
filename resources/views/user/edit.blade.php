@extends('layouts.app')

@section('content')
<h1>Edit Profile</h1>
<form id="edit_profile" method="POST" action="{{ route('user.update', Auth::user()) }}">
    @csrf
    @method('PUT')
    <h3>About Me:</h3>
    <textarea 
        form="edit_profile"
        class="form-control" name="bio" id="bio" rows="3" 
        placeholder="Tell others a bit about yourself." >{{ $user->bio }}</textarea>

    <br/>

    <h3>My courses:</h3>
    <p>Edit current courses:</p>
    <div>
        <input class="form-control" name="courses" id="courses" type="text" data-role="tagsinput" value="{{ $coursenames }}"> 
    </div>

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


