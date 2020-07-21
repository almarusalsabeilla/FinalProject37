@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Berikan Komentar</h3>

    <div class="row mt-5">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                  @if (isset($data->title))
                      <h3>{{$data->title}}</h3>
                      <span class="text-muted">Ditanyakan pada {{$data->created_at}}</span>
                      <hr>
                  @endif
                  {{$data->content}}

                  <br><br><div class="text-end">
                      <p class="text-right">Ditanyakan oleh <br>{{$data->user->name}}</p>
                  </div>
                </div>
            </div>

            <form action="{{url('comments')}}" method="post">
            @csrf

            <div class="form-group mt-3">
                <textarea
                    class="form-control form-control-sm"
                    name="content"
                    rows="8"
                    cols="95"
                ></textarea>
            </div>

            <input type="hidden" name="payload" value="{{$data}}">

            <button type="submit" class="btn btn-primary">Simpan Komentar</button>
            </form>
        </div>

        <div class="col-4">
          <div class="card">
              <div class="card-body">

              </div>
          </div>
        </div>
    </div>
</div>
@endsection