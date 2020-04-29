<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupRequest extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'requester_id','requestee_id','post_id','status','note'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'requestee_id');
    }

    public function requester() {
        return $this->belongsTo('App\User', 'requester_id');
    }

    public function post() {
        return $this->belongsTo('App\Post','post_id');
    }
}
