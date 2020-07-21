@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col-2">
                <ul class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="/home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang</a>
                    </li>
                </ul>
            </div>

            <div class="col-8">
                <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                        <h3>Daftar Pertanyaan</h3>
                    </div>

                    <div class="ml-auto p-2 bd-highlight">
                        <a href="/questions/ask" class="btn btn-primary" role="button">Ajukan Pertanyaan</a>
                    </div>
                </div>

                @foreach ($questions as $question)
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-auto text-center pt-1">
                                    {{count($question->upvotes) - count($question->downvotes)}}
                                    <br>
                                    <small>Vote</small>
                                </div>

                                @if ($question->selected_answer != null)
                                    <div class="col-md-auto text-center bg-success pt-1 rounded">
                                        <span class="text-white">{{ count($question->answers) }}</span><br>
                                        <small class="text-white">Jawaban</small>
                                    </div>
                                @else
                                    <div class="col-md-auto text-center pt-1">
                                        <span>{{ count($question->answers) }}</span><br>
                                        <small>Jawaban</small>
                                    </div>
                                @endif


                                <div class="col">
                                    <a href="/questions/{{$question->id}}" style="text-decoration: none">{{$question->title}}</a>

                                    <div class="d-flex bd-highlight mb-3">
                                        <div class="bd-highlight">
                                            @foreach ($question->questionTag as $key)
                                                <a href="home?tag={{$key->tag->name}}" class="badge badge-primary">{{$key->tag->name}}</a>
                                            @endforeach
                                        </div>

                                        <div class="ml-auto bd-highlight">
                                            <small>
                                                <div class="text-right">
                                                    <small class="text-muted">
                                                        Ditanyakan oleh
                                                        <a href="#" style="text-decoration: none;">{{$question->user->name}}</a>
                                                        {{$question->user->reputation}}
                                                    </small>
                                                </div>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-2">
                
            </div>
        </div>
    </div>
</div>
@endsection