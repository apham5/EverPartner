@extends('layouts.app')

@section('content')

@if (!$has_courses)
    <h1 align="center">Welcome {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}!<h1>
    <h5 align="center"><a href="{{ route('user.edit', Auth::user()->id) }}">Go to your profile</a> and add your current courses to start using EverPartner!</h5>
@else
    @foreach ($courses as $course)
        @php ($course->posts)
        @php ($course->users)
    @endforeach
    <home :courses="{{ $courses }}" :user_id="{{ Auth::user()->id }}"></home>
@endif

@endsection
