@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col-2">
                <ul class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link" href="/home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Pertanyaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang</a>
                    </li>
                </ul>
            </div>

            <div class="col-10">
                <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                        <h3>{{$question->title}}</h3>
                        <span class="text-muted">Ditanyakan pada {{$question->created_at}}</span>
                    </div>

                    <div class="ml-auto p-2 bd-highlight">
                        <a href="/questions/ask" class="btn btn-primary" role="button">Ajukan Pertanyaan</a>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-md-auto text-center">
                                <form action="{{url('votes')}}" method="post">
                                    @csrf
                                    <input name="question" type="hidden" value="{{$question}}">
                                    <input name="user_id" type="hidden" value="{{$user->id}}">
                                    <input name="type" type="hidden" value="is_upvote">

                                    <button
                                        type="submit"
                                        class="btn btn-link btn-sm"
                                        {{$question->user_id == $user->id ? "disabled" : ""}}
                                    ><i class='fas fa-caret-up' style='font-size:36px'></i>
                                    </button>
                                </form>

                                <span style='font-size:24px'>
                                    {{count($question->upvotes) - count($question->downvotes)}}
                                </span>

                                <form action="{{url('votes')}}" method="post">
                                    @csrf
                                    <input name="question" type="hidden" value="{{$question}}">
                                    <input name="user_id" type="hidden" value="{{$user->id}}">
                                    <input name="type" type="hidden" value="is_downvote">

                                    <button
                                        type="submit"
                                        class="btn btn-link btn-sm"
                                        {{$question->user_id == $user->id || $user->reputation < 15 ? "disabled" : ""}}
                                    ><i class='fas fa-caret-down' style='font-size:36px'></i>
                                    </button>
                                </form>
                            </div>

                            <div class="col">
                                {!! $question->content !!}

                                @if ($question->created_at != $question->updated_at)
                                    <br><div class="text-right">- edited</div>
                                @endif

                                @foreach ($question->questionTag as $key)
                                    <a href="#" class="badge badge-primary">{{$key->tag->name}}</a>
                                @endforeach

                                <br><br>
                                <div class="d-flex bd-highlight mb-3">
                                    <div class="bd-highlight">
                                        @if ($question->user->id == $user->id)
                                            <a href="/questions/{{$question->id}}/edit" style="text-decoration: none">
                                                <small>Ubah</small>
                                            </a>
                                        @endif
                                    </div>

                                    <div class="ml-auto bd-highlight">
                                        <small>
                                            <p class="text-right">
                                                Ditanyakan oleh <br>
                                                <a href="#" style="text-decoration: none;">{{$question->user->name}}</a>
                                                {{$question->user->reputation}}
                                            </p>
                                        </small>
                                    </div>
                                </div>

                                @foreach ($question->comments as $comment)
                                    <hr>
                                        <small class="form-text text-muted">
                                            {!! $comment->content !!} - {{$comment->user->name}}
                                        </small>
                                    </hr>
                                @endforeach
                                <hr>
                                <small class="form-text text-muted">
                                    <a href="/comments?question_id={{$question->id}}" style="text-decoration: none">add comment</a>
                                </small>
                            </div>
                        </div>

                        @if ($question->selected_answer != null)
                            <hr><br>
                            <div>
                                <h4>Jawaban terpilih</h4>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-auto text-center">
                                    <form action="{{url('votes')}}" method="post">
                                        @csrf
                                        <input name="question_id" type="hidden" value="{{$question->id}}">
                                        <input name="answer" type="hidden" value="{{$selected_answer}}">
                                        <input name="user_id" type="hidden" value="{{$user->id}}">
                                        <input name="type" type="hidden" value="is_upvote">

                                        <button
                                            type="submit"
                                            class="btn btn-link btn-sm"
                                            {{$selected_answer->user_id == $user->id ? "disabled" : ""}}
                                        ><i class='fas fa-caret-up' style='font-size:36px'></i>
                                        </button>
                                    </form>

                                    <span style='font-size:24px'>
                                        {{count($selected_answer->upvotes) - count($selected_answer->downvotes)}}
                                    </span>

                                    <form action="{{url('votes')}}" method="post">
                                        @csrf
                                        <input name="question_id" type="hidden" value="{{$question->id}}">
                                        <input name="answer" type="hidden" value="{{$selected_answer}}">
                                        <input name="user_id" type="hidden" value="{{$user->id}}">
                                        <input name="type" type="hidden" value="is_downvote">

                                        <button
                                            type="submit"
                                            class="btn btn-link btn-sm"
                                            {{$selected_answer->user_id == $user->id || $user->reputation < 15 ? "disabled" : ""}}
                                        ><i class='fas fa-caret-down' style='font-size:36px'></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="col">
                                    {!! $selected_answer->content !!}

                                    <br><br>
                                    <div class="d-flex bd-highlight mb-3">
                                        <div class="bd-highlight">
                                            @if ($question->user->id == $user->id && $question->selected_answer != null)
                                                <form action="{{url('questions/' . $question->id)}}" method="post">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="PUT">
                                                    <input name="answer" type="hidden" value="{{$selected_answer}}">

                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-danger btn-sm"
                                                    >
                                                        Batalkan pilihan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <div class="ml-auto bd-highlight">
                                            <small>
                                                <p class="text-right">
                                                    Dijawab oleh <br>
                                                    <a href="#" style="text-decoration: none;">{{$selected_answer->user->name}}</a>
                                                    {{$selected_answer->user->reputation}}
                                                </p>
                                            </small>
                                        </div>
                                    </div>

                                    @foreach ($selected_answer->comments as $comment)
                                        <hr>
                                            <small class="form-text text-muted">
                                                {!! $comment->content !!} - {{$comment->user->name}}
                                            </small>
                                        </hr>
                                    @endforeach
                                    <hr>
                                    <small class="form-text text-muted">
                                        <a href="/comments?answer_id={{$selected_answer->id}}" style="text-decoration: none">add comment</a>
                                    </small>
                                </div>
                            </div>
                        @endif

                        <hr>

                        <br>
                        <div>
                            <h4>{{ count($answers) }} Jawaban</h4>
                        </div>
                        <br>

                        @foreach ($answers as $answer)
                            <div class="row">
                                <div class="col-md-auto text-center">
                                    <form action="{{url('votes')}}" method="post">
                                        @csrf
                                        <input name="question_id" type="hidden" value="{{$question->id}}">
                                        <input name="answer" type="hidden" value="{{$answer}}">
                                        <input name="user_id" type="hidden" value="{{$user->id}}">
                                        <input name="type" type="hidden" value="is_upvote">

                                        <button
                                            type="submit"
                                            class="btn btn-link btn-sm"
                                            {{$answer->user_id == $user->id ? "disabled" : ""}}
                                        ><i class='fas fa-caret-up' style='font-size:36px'></i>
                                        </button>
                                    </form>

                                    <span style='font-size:24px'>
                                        {{count($answer->upvotes) - count($answer->downvotes)}}
                                    </span>

                                    <form action="{{url('votes')}}" method="post">
                                        @csrf
                                        <input name="question_id" type="hidden" value="{{$question->id}}">
                                        <input name="answer" type="hidden" value="{{$answer}}">
                                        <input name="user_id" type="hidden" value="{{$user->id}}">
                                        <input name="type" type="hidden" value="is_downvote">

                                        <button
                                            type="submit"
                                            class="btn btn-link btn-sm"
                                            {{$answer->user_id == $user->id || $user->reputation < 15 ? "disabled" : ""}}
                                        ><i class='fas fa-caret-down' style='font-size:36px'></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="col">
                                    {!! $answer->content !!}

                                    <br><br>
                                    <div class="d-flex bd-highlight mb-3">
                                        <div class="bd-highlight">
                                            @if ($question->user->id == $user->id && $question->selected_answer == null)
                                                <form action="{{url('questions/' . $question->id)}}" method="post">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="PUT">
                                                    <input name="answer" type="hidden" value="{{$answer}}">

                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-success btn-sm"
                                                    >
                                                        Pilih sebagai jawaban tepat
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <div class="ml-auto bd-highlight">
                                            <small>
                                                <p class="text-right">
                                                    Dijawab oleh <br>
                                                    <a href="#" style="text-decoration: none;">{{$answer->user->name}}</a>
                                                    {{$answer->user->reputation}}
                                                </p>
                                            </small>
                                        </div>
                                    </div>

                                    @foreach ($answer->comments as $comment)
                                        <hr>
                                            <small class="form-text text-muted">
                                                {!! $comment->content !!} - {{$comment->user->name}}
                                            </small>
                                        </hr>
                                    @endforeach
                                    <hr>
                                    <small class="form-text text-muted">
                                        <a href="/comments?answer_id={{$answer->id}}" style="text-decoration: none">add comment</a>
                                    </small>
                                </div>
                            </div>

                            <hr>
                        @endforeach

                        <br>
                        <div>
                            <h4>Jawaban Anda</h4>
                        </div>

                        <form action="{{url('answers')}}" method="post">
                        @csrf

                        <div class="form-group">
                            <textarea
                                class="form-control form-control-sm"
                                name="content"
                                rows="8"
                                cols="95"
                                id="questionContent"
                            ></textarea>
                        </div>

                        <input type="hidden" name="question_id" value="{{$question->id}}">

                        <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                        </form>
                    </div>

                    <div class="3">
                        right side
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection