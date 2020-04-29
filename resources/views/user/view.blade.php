@extends('layouts.app')

@section('content')
<div class="row justify-content-between">
    <div class="col">
        <h1>{{ $user->firstname }} {{ $user->lastname }}</p>
    </div>
    <div class="col-md-auto">
    @if ($self_profile)
        <a class="btn btn-primary" href="{{ route('user.edit', Auth::user()) }}" role="button"><i class="fas fa-edit"></i>  Edit Profile</a>
    @else
        <a class="btn btn-primary" href="#" role="button"><i class="fas fa-star-half-alt"></i>  Review</a>  <!-- missing route -->
        <a class="btn btn-primary" href="#" role="button"><i class="fas fa-comments"></i>  Message</a>  <!-- missing route -->
    @endif
    </div>
</div>



<h3>About me:</h3>
@if (is_null($user->bio))
    <p><i>Empty</i></p>
@else
    <p>{{ $user->bio }}</p>
@endif

<br/>

<h3>My courses:</h3>
<ul>
    <li>
        <b>Current courses: </b>
        @if ($courses == '')
            <i>none</i>
        @else
            {{ $courses }}
        @endif
    </li>
    <li><b>Past courses: </b><i>none</i></li>
</ul>

<br/>

<h3>Reviews: </h3>
@if (count($reviews) == 0)
    <i>This user currently has no reviews.</i>
@else
    <b>Average rating: {{ $avg_rating }}/5</b>
    @foreach($reviews as $review)
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Rating: {{ $review->rating }}/5 </h5>
            <p class="card-text">{{ $review->content }}</p>
            <p class="card-text"><small class="text-muted">{{ $review->created_at }}</small></p>
        </div>
    </div>
    @endforeach
@endif
@endsection