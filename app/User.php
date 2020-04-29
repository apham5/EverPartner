<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $update_rules = [
        'courses' => 'required',
        'courses.*' => 'min:6|alpha_num'
    ];

    public static $update_messages = [
        'courses.required' => 'Please list the courses you are currently enrolled in.',
        'courses.*' => 'Course names can only be made up of alphanumerical characters and should be 6 characters or more.'
    ];

    public function posts() {
        return $this->hasMany('App\Post','poster_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment','poster_id');
    }

    public function messages() {
        return $this->hasMany('App\Message','sender_id');
    }

    public function notifications() {
        return $this->hasMany('App\Notification','notified_id');
    }

    public function groupRequests() {
        return $this->hasMany('App\GroupRequest','requestee_id');
    }

    public function sentGroupRequests() {
        return $this->hasMany('App\GroupRequest','requester_id');
    }

    public function reviews() {
        return $this->hasMany('App\Review','reviewee_id');
    }

    public function courses() {
        return $this->belongsToMany('App\Course', 'user_class','user_id','class_id');
    }
}
