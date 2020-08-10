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
            <th width="70%" class="text-center">Importovat</th>
            <th>Smazat soubor</th>
        </tr>
        </thead>
        <tbody>
        @php($j = 1)
        @if($filesInfo)
        @foreach($filesInfo as $file)
            <tr class="">
                <td></td>
                <td><strong>{{pathinfo($file['file'], PATHINFO_BASENAME)}}</strong></td>
                <td>
                    <?php
                        $limit = 20;
                        if($file['count'] < $limit) {
                            $limit = $file['count'];
                        }
                    ?>

                        <table class="table">
                            @php($i = 0)
                                <tr>
                                    <td class="text-center">
                                        {{--}}
                                        <a id="{{$j}}_{{$i}}"
                                           href="import-events?file={{$file['file']}}&file_id={{$j}}&from={{$i}}&to=@if($i + $limit > $file['count']){{$file['count']}}@else{{$i + $limit}}@endif"
                                           class="ajax-import">
                                            <img src="{{asset('img/admin/plus_black.svg')}}" alt="Importovat" class="button-import">
                                            <div class="loader"></div>
                                        </a>
                                        {{--}}
                                        <div class="js-import-button-content js-import-button-content-{{$j}}">
                                            <img src="{{asset('img/admin/plus_black.svg')}}" alt="Importovat" class="button-import" data-count="{{$file['count']}}" data-id="{{$j}}" data-href="import-events?file={{$file['file']}}&file_id={{$j}}">

                                            <div class="js-progress js-progress-{{$j}}" style="display: none">
                                                <div class="myProgress " >
                                                    <div class="myBar"></div>
                                                </div>
                                                <div class="imported">
                                                    Importovano akci <span class="js-counter">0</span>/{{$file['count']}}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="js-import-errors-{{$j}}">

                                        </div>
                                        Celkem událostí - {{$file['count']}}
                                    </td>
                                </tr>
                        </table>
                </td>
                <td>
                    <a href="import-delete?file={{$file['file']}}" class="" title="Smazat" data-tooltip="smazat"
                       name="smazat" type="button"><img
                                src="{{asset('img/admin//remove.svg')}}" alt="Smazat"></a>
                </td>

            </tr>
            @php($j++)
        @endforeach
            @endif
        </tbody>
    </table>

@endsection

@section('post-footer')
    @include('admin.event.addModal')
    @include('admin.components.removeModal')
@endsection


