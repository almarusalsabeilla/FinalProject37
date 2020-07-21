<?php

namespace App\Http\Controllers;

use App\Vote;
use App\User;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Vote::where('user_id', $request->user_id);

        if(isset($request->answer)) {
            $request->answer = json_decode($request->answer);
            $question_id = $request->question_id;
            $owner_id = $request->answer->user_id;

            $model->where('answer_id', $request->answer->id);
        } else {
            $request->question = json_decode($request->question);
            $question_id = $request->question->id;
            $owner_id = $request->question->user_id;

            $model->where('question_id', $request->question->id);
        }

        if($model->first() != null) {
            // reset reputation point
            if($model->first()->is_upvote) {
                $point= -10;
            } else {
                $point = 1;
            }

            $owner = User::find($owner_id);
            $owner->reputation += $point;
            $owner->save();

            // delete if exist
            $model->first()->delete();
        } else {
            $vote = new Vote;
            $vote->user_id = $request->user_id;

            if(isset($request->answer)) {
                $vote->answer_id = $request->answer->id;
            } else {
                $vote->question_id = $request->question->id;
            }

            if($request->type == 'is_upvote') {
                $vote->is_upvote = true;
                $point = 10;
            } else {
                $vote->is_downvote = true;
                $point = -1;
            }

            $vote->save();

            $owner = User::find($owner_id);
            $owner->reputation += $point;
            $owner->save();
        }

        return redirect()->to('questions/' . $question_id);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        //
    }
}
