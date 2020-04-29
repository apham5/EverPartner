<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

use App\User;
use App\Course;

class UserController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    private function getCoursesAsString(User $user) {
        $courses = $user->courses()->select('classname')->get();
        $coursenames = '';
        foreach($courses as $course) {
            $coursenames .= $course->classname . ', ';
        }
        return $coursenames;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $reviews = $user->reviews;
        $avg_rating = $user->reviews->avg('rating');
        $self_profile = false;
        if(Auth::user()->id == $user->id) {
            $self_profile=true;
        }
        return view('user.view', ['user' => $user, 'self_profile' => $self_profile, 'courses' => $this->getCoursesAsString($user), 'reviews' => $reviews, 'avg_rating' => $avg_rating]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if ($user != Auth::user()) {
            abort(403, 'Unauthorized action.');
        }
        return view('user.edit', ['user' => $user, 'coursenames' => $this->getCoursesAsString($user)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!is_null($request->courses)) {
            $request->replace(['courses' => explode(',', strtoupper(str_replace(' ','',$request->courses))),
                               'bio'     => $request->bio ]);
        }
        $validator = Validator::make($request->all(), User::$update_rules, User::$update_messages);
        if ($validator->fails()) {
            return redirect()->route('user.edit', $user)->withErrors($validator)->withInput();
        }

        if (!is_null($request->bio)) {
            $user->bio = $request->bio;
        }

        $curr_courses = $user->courses()->select('classname')->get()->toArray();
        if (count($curr_courses) != 0) {
            foreach($curr_courses as $curr_course) {
                if (!in_array($curr_course, $request->courses)) {
                    $removing = Course::where('classname', $curr_course)->first()->id;
                    $user->courses()->detach($removing);
                }
            }
        }

        $curr_courses = $user->courses()->select('classname')->get()->toArray();
        foreach($request->courses as $entered_course) {
            if (!in_array($entered_course, $curr_courses)) {
                $existing_course = Course::where('classname',$entered_course)->first();
                if ($existing_course) {
                    $user->courses()->attach($existing_course->id);
                }
                else {
                    $user->courses()->create([
                        'classname'=> $entered_course
                    ]);
                }
            }
        }

        $user->save();

        //do some actual updating here
        return redirect()->route('user.show', $user)->withMessage('Your profile has been updated.');
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
