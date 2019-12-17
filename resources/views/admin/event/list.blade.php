@extends('admin.admin-layout')

@section('title', 'Akce')

@section('content')
    <div class="flx sb-c mt30 devpow">
        <h1 class="title">Všechny <span>akce dle parametru</span></h1>
        <button class="button add addAction" type="button" data-token="{{csrf_token()}}"
                data-model={{App\Model\Event::class}}><span class="plus"><img src="{{asset('img/admin/plus.svg')}}"
                                                                              alt="plus"></span>Nová akce
        </button>
    </div>

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
        <table class="table">
            <thead>
            <tr>
                <th><input name="" type="checkbox"></th>
                <th>NÁZEV</th>
                <th>OKRES</th>
                <th>MÍSTO</th>
                <th>ZAČÁTEK</th>
                <th>KONEC</th>
                <th>POŘADATEL</th>
                <th>FOTO</th>
                <th>POSLEDNÍ ZMĚNA</th>
                <th>AKCE</th>
            </tr>
            </thead>
            <tbody>
            @forelse($events as $event)
                <tr class="row-{{$event->id}}">
                    <td data-name="Označit"><input name="ids[]" type="checkbox" value="{{$event->id}}"></td>
                    <td data-name="Název">{{$event->title}}</td>
                    <td data-name="Okres">{{$event->district ? $event->district->name : ''}}</td>
                    <td data-name="Místo">{{$event->place ? $event->place->name : ''}}</td>
                    <td data-name="Začátek">{{$event->date_from}}</td>
                    <td data-name="Konec">{{$event->date_to}}</td>
                    <td data-name="Pořadatel">{{$event->contact ? $event->contact->name : ''}}</td>
                    <td data-name="Foto">{{$event->getImagesInfo()}}</td>
                    <td data-name="Poslední změna">{{$event->changed_at}}</td>
                    <td data-name="Akce" class="action">
                        <button class="ac-btn get-modal-content" title="Náhled" data-tooltip="náhled"
                                data-token="{{csrf_token()}}" data-id="{{$event->id}}" data-model="{{get_class($event)}}"
                                name="nahled" type="button"><img src="{{asset('img/admin/detail.svg')}}" alt="Náhled"></button>
                        <button class="ac-btn" title="Smazat" data-tooltip="smazat" data-item-name="událost"
                                data-token="{{csrf_token()}}" data-id="{{$event->id}}" data-model="{{get_class($event)}}"
                                name="smazat" type="button"><img src="{{asset('img/admin/remove.svg')}}" alt="Smazat"></button>
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </form>

    {{-- strankovani --}}
    @include('admin.components.pagination',['items'=> $events])

@endsection

@section('post-footer')
    @include('admin.event.addModal')
    @include('admin.components.removeModal')
@endsection