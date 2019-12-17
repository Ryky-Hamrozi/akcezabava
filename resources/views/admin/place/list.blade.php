@extends('admin.admin-layout')

@section('title', 'Místa')

@section('content')
    <div class="flx sb-c mt30 devpow">
        <h1 class="title">Místa <span>seznam pořadatelských míst</span></h1>
        <button class="button add addAction" data-token="{{csrf_token()}}" data-model={{App\Model\Place::class}} type="button"><span class="plus"><img src="{{asset('img/admin/plus.svg')}}" alt="plus"></span>NOVÉ MÍSTO</button>
    </div>
    <form method="POST" action="{{route('groupAction')}}">
        @csrf
        <input type="hidden" name="model" value="{{App\Model\Place::class}}">
        <div class="filtration">
            <div class="styled-select with-label">
                <label for="oznacene">Označené: </label>
                <select id="oznacene" name="action">
                    <option value="delete">Smazat</option>
                </select>
                <button class="button ml-10">Potvrdit</button>
            </div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>MÍSTO</th>
                <th>OKRES</th>
                {{--<th>KONTAKT</th>--}}
                <th>AKCÍ</th>
                <th>AKCE</th>
            </tr>
            </thead>
            <tbody>



            @forelse($places as $place)
                <tr class="row-{{$place->id}}">
                    <td data-name="Označit"><input name="ids[]" value="{{$place->id}}" type="checkbox"></td>
                    <td data-name="Místo">{{$place->name}}</td>
                    <td data-name="Okres">{{$place->district->name}}</td>
                    {{--<td data-name="Kontakt">Mgr. Jiří Králík</td>--}}
                    <td data-name="Akcí">{{$place->getEventsCount()}}</td>
                    <td data-name="Akce" class="action">
                        <button class="ac-btn get-modal-content" title="Náhled"  data-token="{{csrf_token()}}" data-id="{{$place->id}}"  data-model="{{get_class($place)}}" name="nahled" type="button"><img src="{{asset('img/admin/detail.svg')}}" alt="Náhled"></button>
                        <!-- <button class="ac-btn" title="Upravit" data-tooltip="upravit" name="upravit" type="button"><img src="img/edit.svg" alt="Upravit"></button> -->
                        <button class="ac-btn" title="Smazat" data-tooltip="smazat"  data-item-name="místo" data-token="{{csrf_token()}}" data-id="{{$place->id}}"  data-model="{{get_class($place)}}" name="smazat" type="button"><img src="{{asset('img/admin/remove.svg')}}" alt="Smazat"></button>
                    </td>
                </tr>
            @empty

            @endforelse
            </tbody>
        </table>
    </form>
    {{-- strankovani --}}
    @include('admin.components.pagination',['items'=> $places])

@endsection

@section('post-footer')
    @include('admin.place.addModal')
    @include('admin.components.removeModal')
@endsection