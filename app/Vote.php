<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'votes';

    protected $fillable = ['question_id', 'user_id', 'answer_id', 'is_upvote', 'is_downvote'];
}
