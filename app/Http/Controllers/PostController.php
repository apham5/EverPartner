<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

use App\Post;
use App\Course;
use App\Comment;

class PostController extends Controller
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
        $posts = Auth::user()->posts->sortByDesc('updated_at');
        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (count(Auth::user()->courses()->where('id', $request->class_id)->get()) == 0) {
            abort(403, 'Unauthorized action.');
        }
        $coursename = Course::find($request->class_id)->classname;
        return view('post.create', ['class_id' => $request->class_id, 'coursename' => $coursename]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Post::$create_rules, Post::$create_messages);
        if ($validator->fails()) {
            return redirect()->route('post.create', $request->class_id)->withErrors($validator)->withInput();
        }

        $post = Post::create([
            'assignment' => $request->assignment,
            'partner_num' => $request->partner_num,
            'content' => $request->content,
            'status' => 1,
            'poster_id' => Auth::user()->id,
            'class_id' => $request->class_id
        ]);

        // $post->user()->associate(Auth::user());
        // $post->course()->associate(Course::find($request->class_id));

        $post->save();

        return redirect()->route('post.show', $post)->withMessage('Your request post has been submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $self_post = false;
        if (Auth::user()->posts()->find($post->id)) {
            $self_post = true;
        }
        $request_sent = false;
        if (count(Auth::user()->sentGroupRequests->where('post_id', $post->id)) > 0) {
            $request_sent = true;
        }
        return view('post.view', ['post' => $post, 'self_post' => $self_post, 'request_sent' =>$request_sent]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (count(Auth::user()->posts->where('id', $post->id)) == 0) {
            return new Response('Forbidden', 403);
        }
        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (count(Auth::user()->posts->where('id', $post->id)) == 0) {
            abort(403, 'Unauthorized action.');
        }

        $post->status = $request->status;
        $post->assignment = $request->assignment;
        $post->partner_num = $request->partner_num;
        $post->content = $request->content;

        $post->save();

        return redirect()->route('post.show', $post)->withMessage('Your post has been updated.');
    }

    public function storeComment(Request $request) {
        $validator = Validator::make($request->all(), Comment::$create_rules, Comment::$create_messages);
        if ($validator->fails()) {
            return redirect()->route('post.show', $request->post_id)->withErrors($validator);
        }

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'poster_id' => Auth::user()->id,
            'content' => $request->content
        ]);

        $comment->save();

        return redirect()->route('post.show', $request->post_id)->withMessage('Your follow-up question has been posted.');
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
