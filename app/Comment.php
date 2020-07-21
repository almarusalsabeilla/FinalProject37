<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['question_id', 'user_id', 'answer_id', 'content'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
