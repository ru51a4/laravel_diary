@extends('layouts.app')

@section('content')


            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form action="/diary/create" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Название блога</label>
                                <input type="text" class="form-control" name="name" id="exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Описание блога</label>
                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1"
                                          rows="3"></textarea>
                            </div>
                            <div class="d-flex flex-column align-items-start">
                                <div class="h-captcha" data-sitekey="44bc33ce-4978-4b30-bc7c-7d1249280700"></div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Добавить</button>

                            </div>
                        </form>

                    </div>
                </div>
            </div>


<script>

</script>



@endsection
