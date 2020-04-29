<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Course;
use App\Post;
use App\User;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $has_courses = true;
        $courses = Auth::user()->courses()->get();
        if (count($courses) == 0) {
            $has_courses = false;
        }

        return view('home', ['has_courses' => $has_courses, 'courses' => $courses]);
    }

    public function getPostsForCourse(Request $request) {
        $posts = Post::where('status', 1)->where('class_id', $request->class_id)->get();
        return $posts;
    }

    public function getNamesForPost(Request $request) {
        $user_ids = Post::whereIn('id',$request->post_ids)->select('poster_id')->get();
        $users = User::whereIn('id',$user_ids)->select('id','firstname','lastname')->get()->toArray();

        return $users;
    }
}
