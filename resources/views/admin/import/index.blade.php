@extends('admin.admin-layout')

@section('title', 'Import')

@section('content')

    <div class="flx sb-c mt30 devpow">
        <h1 class="title">Import akcí</h1>

    </div>
    <br>

    <form action="{{route('import.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="import_file">
        <input type="submit">
    </form>

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>NÁZEV</th>
            <th>Importovat po částech</th>
            <th>Smazat soubor</th>
        </tr>
        </thead>
        <tbody>
        @php($j = 0)
        @if($filesInfo)
        @forelse($filesInfo as $file)
            <tr class="">
                <td></td>
                <td><strong>{{pathinfo($file['file'], PATHINFO_BASENAME)}}</strong></td>
                <td>
                    @php($limit = 5)
                    @if($file['count'] > $limit)
                        <table class="table">
                            @for($i = 0; $i < $file['count']; $i = $i + $limit)
                                <tr>
                                    <td>
                                        {{$i}}
                                        - @if($i + $limit > $file['count']){{$file['count']}}@else{{$i + $limit}}@endif
                                    </td>
                                    <td>
                                        <a id="{{$j}}_{{$i}}"
                                           href="import-events?file={{$file['file']}}&file_id={{$j}}&from={{$i}}&to=@if($i + $limit > $file['count']){{$file['count']}}@else{{$i + $limit}}@endif"
                                           class="ajax-import">
                                            <img src="{{asset('img/admin/plus_black.svg')}}" alt="Importovat">

                                            <div class="loader"></div>
                                        </a>
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    @endif
                    Celkem událostí - {{$file['count']}}
                </td>
                <td>
                    <a href="import-delete?file={{$file['file']}}" class="" title="Smazat" data-tooltip="smazat"
                       name="smazat" type="button"><img
                                src="{{asset('img/admin//remove.svg')}}" alt="Smazat"></a>
                </td>
            </tr>
        @empty
            @php($j++)
        @endforelse
            @endif
        </tbody>
    </table>

@endsection

@section('post-footer')
    @include('admin.event.addModal')
    @include('admin.components.removeModal')
@endsection