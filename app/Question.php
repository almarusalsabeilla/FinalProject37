<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = ['title', 'content', 'user_id', 'selected_answer'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function selectedAnswer() {
        return $this->belongsTo('App\Answer', 'selected_answer');
    }

    public function answers() {
        return $this->hasMany('App\Answer', 'question_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'question_id');
    }

    public function upvotes() {
        return $this->hasMany('App\Vote', 'question_id')->where('is_upvote', '=', 'true');
    }

    public function downvotes() {
        return $this->hasMany('App\Vote', 'question_id')->where('is_downvote', '=', 'true');
    }

    public function questionTag() {
        return $this->hasMany('App\QuestionTag', 'question_id');
    }
}
