@extends('front.front-layout')

@section('title', 'Reklama na webu')

@section('content')
    @include('front.spinner', ['class' => 'center'])
    <div class="new-action-page" id="js-reklama-na-webu-content">
        @include('front.advertistingForm', ['errors' => $errors])
    </div>

@endsection