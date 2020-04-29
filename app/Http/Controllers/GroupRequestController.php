<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

use App\GroupRequest;
use App\Post;

class GroupRequestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $received = GroupRequest::where('requestee_id', Auth::user()->id)->orderByDesc('created_at')->get();
        $sent = GroupRequest::where('requester_id', Auth::user()->id)->orderByDesc('created_at')->get();
        return view('grouprequest.index', ['received' => $received, 'sent' => $sent]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $post = Post::find($request->post_id);
        if (is_null($post)) {
            abort(404);
        }
        else if ($post->poster_id == Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        else {
            return view('grouprequest.create', ['post_id'=> $post->id]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::find($request->post_id);
        $note = $request->content ?? '';

        $grouprequest = GroupRequest::create([
            'requester_id' => Auth::user()->id,
            'requestee_id' => $post->poster_id,
            'post_id' => $post->id, 
            'status' => 0,  //0 is pending, 1 is accepted, 2 is denied
            'note' => $note
        ]);

        $grouprequest->save();

        return redirect()->route('post.show', $post)->withMessage('Your request to join has been submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupRequest $grouprequest)
    {
        $grouprequest->status = $request->status;
        $grouprequest->save();
        return redirect()->route('grouprequest.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
