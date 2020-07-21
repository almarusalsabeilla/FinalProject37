<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Question;
use App\Answer;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->question_id)) {
            $data = Question::where('id', $request->question_id)->with('user')->first();
        }

        if(isset($request->answer_id)) {
            $data = Answer::where('id', $request->answer_id)->with('user')->first();
        }

        return view('comment', ['data' => $data]);
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
        $request->payload = json_decode($request->payload);
        $user = Auth::user();
        $comment = new Comment;

        if (isset($request->payload->title)) {
            $comment->question_id = $request->payload->id;
            $question_id = $request->payload->id;
        } else {
            $comment->answer_id = $request->payload->id;
            $question_id = $request->payload->question_id;
        }

        $comment->user_id = $user->id;
        $comment->content = $request->content;
        $comment->save();

        return redirect()->to('questions/' . $question_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
