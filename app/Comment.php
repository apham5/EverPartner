<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id', 'poster_id', 'content',
    ];

    public static $create_rules = [
        'content' => 'required'
    ];

    public static $create_messages = [
        'content.required' => 'You submitted an empty follow-up question. Please try again.'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'poster_id');
    }

    public function post() {
        return $this->belongsTo('App\Post', 'post_id');
    }
}
