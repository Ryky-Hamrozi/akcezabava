<table class="table">
    <thead>
    <tr>
        <th><input name="" type="checkbox"></th>
        <th>@sortablelink('title', 'NÁZEV')</th>
        <th>@sortablelink('district_id', 'OKRES')</th>
        <th>@sortablelink('place_id', 'MÍSTO')</th>
        <th>@sortablelink('date_from', 'ZAČÁTEK')</th>
        <th>@sortablelink('date_to', 'KONEC')</th>
        <th>@sortablelink('fb_url', 'ZDROJ')</th>
        <th>@sortablelink('image.id', 'FOTO')</th>
        <th>@sortablelink('updated_at', 'Poslední změna')</th>
        <th>SCHVÁLIT</th>
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
            <td data-name="Zdroj">@if($event->fb_url)<span class="facebook">facebook</span>@else Uživatel @endif</td>
            <td data-name="Foto">{{$event->getImagesInfo()}}</td>
            <td data-name="Vloženo">{{$event->updated_at}}</td>
            <td data-name="Schválit">
                <div class="schvalit-chck">
                    <label title="Schválit?">
                        <input name="" type="checkbox" class="approve" data-id="{{$event->id}}" data-url="{{route('approve')}}" data-token="{{csrf_token()}}" {{$event->approved == 1 ? 'checked' : ''}}>
                        <span></span>
                    </label>
                </div>
            </td>
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
