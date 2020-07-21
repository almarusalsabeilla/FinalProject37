<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = ['question_id', 'user_id', 'content', 'is_selected'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'answer_id');
    }

    public function upvotes() {
        return $this->hasMany('App\Vote', 'answer_id')->where('is_upvote', '=', 'true');
    }

    public function downvotes() {
        return $this->hasMany('App\Vote', 'answer_id')->where('is_downvote', '=', 'true');
    }
}
