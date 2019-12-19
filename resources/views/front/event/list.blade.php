@extends('front.front-layout')

@section('title', 'Nová událost')

@section('content')

    @include('front.event.components.eventSearchForm',['districts' => $districts, 'allCategories' => $allCategories])
    @include('front.spinner')
    <div class="js-content-block-events">
        @include('front.event.components.eventSearchFormListResult',['events' => $events])
    </div>

@endsection
