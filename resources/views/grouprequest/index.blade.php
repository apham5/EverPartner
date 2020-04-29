@extends('layouts.app')

@section('content')
<h1>My requests</h1>

@foreach ($received as $request)
    @php ($request->requester)
    @php ($request->post->course)
@endforeach
@foreach ($sent as $request)
    @php ($request->user)
    @php ($request->post->course)
@endforeach

<group-request :received="{{ $received }}" :sent="{{ $sent }}" ></group-request>

<!-- <h3>Received Requests</h3>
@if ( count($received) == 0)
    <p><i>You haven't received any requests.</i></p>
@else
    @foreach( $received as $request )
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col">
                        <p class="card-text"><a href="{{ route('user.show', $request->requester_id) }}">{{ $request->requester->firstname }} {{ $request->requester->lastname }}</a></p>
                    </div>
                    <div class="col-md-auto">
                        <p class="card-text">{{ $request->created_at }}</p>
                    </div>
                </div>
                <p class="card-text"><a href="{{ route('post.show', $request->post_id) }}">{{ $request->post->course->classname }}: {{ $request->post->assignment }}</a></p>
                <p class="card-text">{{ $request->note }}</p>
                <div class="float-right">
                    @if( $request->status == 0 )
                    <div style="display: flex;">
                        <form id="refuse-request" method="POST" action="{{ route('grouprequest.update', $request ) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="btn btn-danger">Refuse</button>
                        </form>
                        <form id="accept-request" method="POST" action="{{ route('grouprequest.update', $request ) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-success">Accept</button>
                        </form>
                    </div>
                    @elseif ( $request->status == 1)
                        <button type="button" class="btn btn-success" disabled>Accepted</button>
                    @else
                        <button type="button" class="btn btn-danger" disabled>Refused</button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif

<br/>

<h3>Sent Requests</h3>
@if ( count($sent) == 0)
    <p><i>You haven't sent any requests.</i></p>
@else
    @foreach( $sent as $request )
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col">
                    <p class="card-text"><a href="{{ route('user.show', $request->requester_id) }}">{{ $request->user->firstname }} {{ $request->user->lastname }}</a></p>
                    </div>
                    <div class="col-md-auto">
                        <p class="card-text">{{ $request->created_at }}</p>
                    </div>
                </div>
                <p class="card-text"><a href="{{ route('post.show', $request->post_id) }}">{{ $request->post->course->classname }}: {{ $request->post->assignment }}</a></p>
                @if ( $request->status == 0)
                    <p class="card-text">Status: <span class="badge badge-secondary">Pending</span></p>
                @elseif ($request->status == 1)
                    <p class="card-text">Status: <span class="badge badge-success">Accepted</span></p>
                @else
                    <p class="card-text">Status: <span class="badge badge-danger">Refused</span></p>
                @endif
                <p class="card-text">{{ $request->note }}</p>
            </div>
        </div>
    @endforeach
@endif -->

@endsection