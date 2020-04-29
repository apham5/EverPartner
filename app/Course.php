<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'classname'
    ];

    public function posts() {
        return $this->hasMany('App\Post', 'class_id')->orderByDesc('created_at');
    }

    public function users() {
        return $this->belongsToMany('App\User', 'user_class','class_id','user_id');
    }
}
