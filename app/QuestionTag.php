<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTag extends Model
{
    protected $table = 'question_tag';

    protected $fillable = ['question_id', 'tag_id'];

    public function tag() {
        return $this->belongsTo('App\Tag', 'tag_id');
    }
}
