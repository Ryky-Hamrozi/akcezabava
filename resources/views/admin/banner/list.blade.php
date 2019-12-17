@extends('admin.admin-layout')

@section('title', 'Bannery')

@section('content')
    <div class="flx sb-c mt30 devpow">
        <h1 class="title">Bannery</h1>
        <button class="button add addAction" data-token="{{csrf_token()}}"
                data-model={{App\Model\Banner::class}} type="button"><span class="plus"><img
                        src="{{asset('img/admin/plus.svg')}}" alt="plus"></span>NOVÝ BANNER
        </button>
    </div>

    <form method="POST" action="{{route('groupAction')}}">
        @csrf
        <input type="hidden" name="model" value="{{App\Model\Banner::class}}">
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
                <th>OBRÁZEK</th>
                <th>NÁZEV</th>
                <th>UMÍSTĚNÍ</th>
                <th>AKCE</th>
            </tr>
            </thead>
            <tbody>
            @forelse($banners as $banner)
                <tr class="row-{{$banner->id}}">
                    <td data-name="Označit"><input name="ids[]" type="checkbox" value="{{$banner->id}}"></td>
                    <td data-name="Obrázek">@if(isset($banner->image))<img src="{{asset($banner->image->thumbnail)}}" alt="banner">@endif</td>
                    <td data-name="Název">{{$banner->name}}</td>
                    <td data-name="Umístění">{{\App\Model\Banner::locations[$banner->location]}}</td>
                    <td data-name="Akce" class="action">
                        <button class="ac-btn get-modal-content" title="Náhled" data-tooltip="náhled"
                                data-token="{{csrf_token()}}" data-id="{{$banner->id}}"
                                data-model="{{get_class($banner)}}"
                                name="nahled" type="button"><img
                                    src="{{asset('img/admin/detail.svg')}}" alt="Náhled"></button>
                        <!-- <button class="ac-btn" title="Upravit" data-tooltip="upravit" name="upravit" type="button"><img src="img/edit.svg" alt="Upravit"></button> -->
                        <button class="ac-btn" title="Smazat" data-tooltip="smazat" data-item-name="banner"
                                data-token="{{csrf_token()}}" data-id="{{$banner->id}}" data-model="{{get_class($banner)}}"
                                name="smazat" type="button"><img
                                    src="{{asset('img/admin//remove.svg')}}" alt="Smazat"></button>
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </form>
    {{-- strankovani --}}
    @include('admin.components.pagination',['items'=> $banners])

@endsection

@section('post-footer')
    @include('admin.contact.addModal')
    @include('admin.components.removeModal')
@endsection