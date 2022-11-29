@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                whitelist - {{$diary->whitelist ? "включен" : "выключен"}}
                @if($diary->whitelist)
                    <a href="/diary/whitelist/on/{{$diary["id"]}}/0">выключить whitelist</a>
                @else
                    <a href="/diary/whitelist/on/{{$diary["id"]}}/1">включить whitelist</a>
                @endif
                <div class="d-flex justify-content-center">
                    <div class="list">
                        <ul>
                            @foreach($whitelist as $user)
                                <li>{{$user["name"]}} <a
                                        href="/diary/whitelist/delete/{{$user["id"]}}/{{$diary["id"]}}">delete</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="">
                        <form>
                            <input onkeyup="getUsers(event)" type="text">
                            <ul class="list-autocomplete">

                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function getUsers(e) {
            let str = e.target.value;
            const params = {
                str: str,
                diaryId: {{$diary["id"]}}
            };
            const options = {
                type: 'POST',
                data: (params)
            };
            $.ajax("/user/findusers", options).done((c) => {
                let html = `<ul>` + c.map((item) => {
                    return `<li>${item.name} <a href="/diary/whitelist/add/${item.id}/{{$diary["id"]}}">add</a> </li>`;
                }).join("") + `</ul>`;
                document.querySelector(".list-autocomplete").innerHTML = html;
            })
        }
    </script>

@endsection