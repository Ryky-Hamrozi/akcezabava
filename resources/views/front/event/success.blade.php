@extends('front.front-layout')

@section('title', 'Úvod')

@section('content')

<div class="success">
    <img src="{{asset('img/front/jbsdone.svg')}}" alt="úspěšně odeslána">
    <h1 class="title">Vaše událost byla úspěšně odeslána</h1>
    <p>Událost bude zveřejněna až po schválení administrátorem což může nějakou dobu trvat. <br>O průběhu budete informováni emailem.</p>
    <a class="button back" href="{{route('home')}}"><img src="{{asset('img/front/ar-l.svg')}}" alt="arrow">zpět na web</a>
</div>

@endsection