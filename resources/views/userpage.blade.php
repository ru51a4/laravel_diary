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
            <form enctype="multipart/form-data" action="/user" method="post">
                @csrf
                <div class="mb-3">
                    <label for="formFile" class="form-label"><img class="avatar m-0"
                                                                  src="{{$user["avatar"] ? $user["avatar"] : ""}}">
                        <br>
                        avatar url:
                    </label>
                    <input type="text" class="form-control" name="avatar" id="exampleFormControlInput1"
                           value="{{$user["avatar"]}}">

                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Обновить</button>
                </div>
            </form>
            @if(1 || $user["name"] == "ru51a4")
                @foreach($users as $user)
                    <form action="/status/{{$user->id}}" method="post">
                        @csrf
                        <div class="name">
                            {{$user->name}}
                        </div>
                        <ul>
                            @foreach($user->statuses as $userStatus)
                                <li><span>{{$userStatus->name}}</span> <a
                                        href="/status/{{$user->id}}/{{$userStatus->id}}">delete</a></li></li>
                            @endforeach
                        </ul>
                        <div class="add_status">
                            <select name="statusId">
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                            <button type="submit">set</button>
                        </div>
                    </form>
                @endforeach
                <form method="post" action="/status/create">
                    @csrf
                    <input type="text" name="name">
                    <button type="submit">add</button>
                </form>
                <ul>
                    @foreach($statuses as $status)
                        <li>
                            <span>{{$status->name}}</span> <a href="/status/deletestatus/{{$status->id}}">delete</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>



@endsection
