@extends('layouts.app')

@section('content')



    <div class="row">
        <div class="my-4">
            <a href="/diary/createform">
                <button type="submit" class="btn btn-primary">Создать блог</button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="d-flex flex-column justify-content-start dashboard">
            @foreach ($diarys as $diary)
                <a href="/diary/{{$diary->id}}">
                    <div class="col-12 card d-flex flex-row">
                        <div class="card-avatar d-flex flex-column justify-content-start">
                            <div class="nickname nickname-author">
                                {{$diary->user->name}}
                                <p class="status">
                                    @if($diary->user->statuses)
                                        @foreach($diary->user->statuses as $status)
                                            {{$status->name}}<br>
                                        @endforeach
                                    @else
                                        {{"блогер" }}
                                    @endif
                                </p></div>
                            <img class="avatar"
                                 src="{{$diary->user->avatar ? $diary->user->avatar : "http://ufland.moy.su/camera_a.gif"}}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"> {{$diary->name}}</h5>
                            <p class="card-text"> {{$diary->description}}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="row mt-4">
        <nav aria-label="...">
            <ul class="pagination d-flex justify-content-end pagination-sm">
                @for ($i = 1; $i < $pages; $i++)
                    @if($i == $page)
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{$page}}</span>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link" href="/home/{{$i}}">{{$i}}</a></li>
                    @endif
                @endfor
            </ul>
        </nav>
    </div>




@endsection
