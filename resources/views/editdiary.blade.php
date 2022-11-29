@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="card">

        </div>
    </div>


    <script>
        let diaryId = {{$diary["id"]}};
    </script>

    <script type="module" src="{{ asset('js/whitelist.mjs')}}"></script>

    <script>
        /*  function getUsers(e) {
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
        }*/
    </script>

@endsection
