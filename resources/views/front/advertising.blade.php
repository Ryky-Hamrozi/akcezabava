@extends('front.front-layout')

@section('title', 'Úvod')

@section('content')

    <div class="new-action-page">
        <h1 class="title"><span>Chcete reklamu</span> na našem webu?</h1>
        <form method="post" action="{{route('process-advertising')}}" enctype="multipart/form-data">
            @csrf
            <div class="inputs flx-w row">
                <div class="box-input w33p">
                    <input id="person" name="person" type="text" required="">
                    <label for="person">Jméno a příjmení</label>
                </div>
                <div class="box-input w33p">
                    <input id="email" name="email" type="email" required="">
                    <label for="email">E-mail</label>
                </div>
                <div class="box-input w33p">
                    <input id="phone" name="phone" type="tel" required="">
                    <label for="phone">Telefon</label>
                </div>
                <div class="box-input w50p">
                    <textarea id="dsc" name="dsc" required=""></textarea>
                    <label for="dsc">popis navrhované spolupráce</label>
                </div>
                <div class="box-input w50p">
                    <input id="uplaod" name="uplaod" type="file">
                    <label for="uplaod">nahrajte přílohu</label>
                </div>
            </div>
            <div class="center-button flx sb-c">
                <button class="button green" type="submit">odeslat</button>
            </div>
        </form>
    </div>

@endsection