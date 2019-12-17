@extends('admin.admin-layout')

@section('title', 'Kontakty')

@section('content')
    <div class="flx sb-c mt30 devpow">
        <h1 class="title">Kontakty <span>na zákazníky včetně firem</span></h1>
        <button class="button add addAction" data-token="{{csrf_token()}}"
                data-model={{App\Model\Contact::class}} type="button"><span class="plus"><img
                        src="{{asset('img/admin/plus.svg')}}" alt="plus"></span>NOVÝ KONTAKT
        </button>
    </div>

    <form method="POST" action="{{route('groupAction')}}">
        @csrf
        <input type="hidden" name="model" value="{{App\Model\Contact::class}}">
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
                <th>JMÉNO</th>
                <th>FIRMA</th>
                <th>OKRES</th>
                <th>TELEFON</th>
                <th>EMAIL</th>
                <th>POČET AKCÍ</th>
                <th>AKCE</th>
            </tr>
            </thead>
            <tbody>
            @forelse($contacts as $contact)
                <tr class="row-{{$contact->id}}">
                    <td data-name="Označit"><input name="ids[]" type="checkbox" value="{{$contact->id}}"></td>
                    <td data-name="Jméno">{{$contact->name}}</td>
                    <td data-name="Firma">{{$contact->company}}</td>
                    <td data-name="Okres">{{$contact->district->name}}</td>
                    <td data-name="Telefon">{{$contact->phone}}</td>
                    <td data-name="Email">{{$contact->email}}</td>
                    <td data-name="Akcí">{{$contact->getEventsCount()}}</td>
                    <td data-name="Akce" class="action">
                        <button class="ac-btn get-modal-content" title="Náhled" data-tooltip="náhled"
                                data-token="{{csrf_token()}}" data-id="{{$contact->id}}"
                                data-model="{{get_class($contact)}}"
                                name="nahled" type="button"><img
                                    src="{{asset('img/admin/detail.svg')}}" alt="Náhled"></button>
                        <!-- <button class="ac-btn" title="Upravit" data-tooltip="upravit" name="upravit" type="button"><img src="img/edit.svg" alt="Upravit"></button> -->
                        <button class="ac-btn" title="Smazat" data-tooltip="smazat" data-item-name="kontakt"
                                data-token="{{csrf_token()}}" data-id="{{$contact->id}}" data-model="{{get_class($contact)}}"
                                name="smazat" type="button"><img
                                    src="{{asset('img/admin//remove.svg')}}" alt="Smazat"></button>
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </form>

    @include('admin.components.pagination',['items'=> $contacts])
@endsection

@section('post-footer')
    @include('admin.contact.addModal')
    @include('admin.components.removeModal')
@endsection