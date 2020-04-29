<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'poster_id','class_id','assignment','partner_num','content', 'status'
    ];

    public static $create_rules = [
        'assignment' => 'required',
        'partner_num' => 'required|numeric',
        'content' => 'required'
    ];

    public static $create_messages = [
        'assignment.required' => 'Please enter the assignment for which you are looking for a group.',
        'partner_num.required' => 'Please enter the number of group members you require for this group.',
        'partmer_num.numeric' => 'The number of group members required can only be a numeric value.',
        'content.required' => 'Please add some more details about your group request.'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'poster_id');
    }

    public function course() {
        return $this->belongsTo('App\Course', 'class_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'post_id');
    }
}
