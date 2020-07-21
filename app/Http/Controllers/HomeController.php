<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = "";
        $data = Question::with(['user', 'answers', 'upvotes', 'downvotes', 'questionTag.tag']);

        if(isset($request->search) && $request->search != null) {
            $search = $request->search;

            $data->where('title', 'ilike', '%' . strtolower($request->search) . '%');
        } else if (isset($request->tag) && $request->tag != null) {
            $search = $request->tag;

            $data->whereHas('questionTag.tag', function($t) use($request) {
                $t->where('name', 'ilike', '%' . strtolower($request->tag) . '%');
            });
        }

        $questions = $data->get();

        return view('home', ['questions' => $questions, 'search' => $search]);
    }
}
