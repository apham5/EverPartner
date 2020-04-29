<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'reviewer_id','reviewee_id','rating','content'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'reviewee_id');
    }
}
