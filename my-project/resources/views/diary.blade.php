@extends('layouts.app')

@section('content')

    <div class="row d-flex justify-content-center">
        <div class="d-flex flex-column col-9 m-4 bg-light">
            <h1 class="display-5 fw-bold">{{$posts[0]["diary"]["name"]}}</h1>
            <p class="col-md-8 fs-4">{{$posts[0]["diary"]["description"]}}</p>

            @if($posts[0]["user"]["id"] == auth()->user()->id)
                <a class="align-self-end" href="/diary/edit/{{$posts[0]["diary"]["id"]}}">whitelist</a>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="d-flex flex-column justify-content-start">
            @foreach ($posts as $post)
                <div class="col-12 card d-flex flex-row">
                    <div class="card-avatar d-flex flex-column justify-content-start">
                        <div class="nickname">
                            <b>{{$post["user"]["name"]}}</b>
                            <p class="status">
                                @if($post['user']['statuses'])
                                    @foreach($post['user']['statuses'] as $status)
                                        {{$status["name"]}}<br>
                                    @endforeach
                                @else
                                    {{"Блогер" }}
                                @endif
                            </p>
                        </div>
                        <img class="avatar"
                             src="{{$post["user"]["avatar"] ? $post["user"]["avatar"] : "http://ufland.moy.su/camera_a.gif"}}">
                    </div>
                    <div class="card-body diary">
                        <div class="card--header">
                            <button id="{{$post["id"]}}"
                                    style=" font-size: 10px; padding: 0px; max-height: 25px;"
                                    class="btn btn-primary btn-reply">>>{{$post["id"]}}</button>
                        </div>
                        <p class="card-text"> {!! $post["message"] !!}
                        </p>
                        <div class="card-bottom">
                            <div style="">
                                @if(isset($replys[$post["id"]]))
                                    @foreach($replys[$post["id"]] as $reply)
                                        <span style="background-color: unset!important; color: #FF6600;"
                                              pid="{{$post["id"]}}" id="{{$reply}}"
                                              class="reply">>>{{$reply}}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div>
                                @if($post["user"]["id"] == auth()->user()->id)
                                    <a href="/editpost/{{$post["diary"]["id"]}}/{{$post["id"]}}">edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row add-post">
        <div class="mt-3">
            <form action="/post/{{$idDiary}}" method="post" class="col-12">
                @csrf
                <div>
                        <textarea class="form-control" name="message" id="exampleFormControlTextarea1"
                                  rows="3"></textarea>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <div class="h-captcha" data-sitekey="44bc33ce-4978-4b30-bc7c-7d1249280700"></div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mt-2">Добавить</button>
                </div>
            </form>
        </div>
    </div>

@endsection
