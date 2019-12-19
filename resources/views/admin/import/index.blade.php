@extends('admin.admin-layout')

@section('title', 'Import')

@section('content')
    <form action="{{route('import.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="import_file">
        <input type="submit">
    </form>
@endsection

@section('post-footer')
    @include('admin.event.addModal')
    @include('admin.components.removeModal')
@endsection