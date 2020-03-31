@extends('admin.admin-layout')

@section('title', 'Akce')

@section('content')

<h1 class="title mt30">Ke schválení <span>z facebooku, nebo od uživatelů</span></h1>
<form method="POST" action="{{route('groupAction')}}">
    @csrf
    <input type="hidden" name="model" value="{{App\Model\Event::class}}">
    <div class="filtration">
        <div class="styled-select with-label">
            <label for="oznacene">Označené: </label>
            <select id="oznacene" name="action">
                <option value="delete">Smazat</option>
            </select>
            <button class="button ml-10">Potvrdit</button>
        </div>
    </div>
    <div class="js-events-table">
        @include('admin.event.components.events_table_forApproval')
    </div>
    <input type="hidden" name="page" value="{{isset($request) ? $request->input('page') : 0}}">
</form>

{{-- strankovani --}}
@include('admin.components.pagination',['items'=> $events])

@endsection

@section('post-footer')
    @include('admin.event.addModal')
    @include('admin.components.removeModal')
@endsection
