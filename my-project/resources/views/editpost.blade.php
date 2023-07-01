@extends('layouts.app')

@section('content')


    <div class="row d-flex justify-content-center">

    </div>
    <div class="row">
        <div class="d-flex flex-column justify-content-start">

        </div>
    </div>
    <div class="row add-post">
        <div class="mt-3">
            <form action="/editpost/{{$diary->id}}/{{$post->id}}"
                  method="post" class="col-12">
                @csrf
                <div>
                            <textarea class="form-control" name="message" id="exampleFormControlTextarea1"
                                      rows="3">{{$post->message}}</textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="/deletepost/{{$diary->id}}/{{$post->id}}">
                        <div name="btn" value="delete" style="margin-right: 20px"
                             class="btn btn-primary mt-2">Удалить
                        </div>
                    </a>
                    <button name="btn" type="submit" class="btn btn-primary mt-2 ml-2">
                        Редактировать
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection
