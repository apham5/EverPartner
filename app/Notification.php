<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notified_id', 'other_id', 'request_id', 'review_id', 'comment_id'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'notified_id');
    }

    public function request() {
        return $this->hasOne('App\Request','request_id');
    }

    public function review() {
        return $this->hasOne('App\Review','review_id');
    }

    public function comment() {
        return $this->hasOne('App\Comment','comment_id');
    }
}
