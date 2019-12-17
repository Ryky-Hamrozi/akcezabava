<div class="modal-handler" id="new-action-modal">
    <div class="modal-content">
        <div class="modal-header flx sb-c">
            <h5>
                @if(isset($item))
                    EDITACE UDÁLOSTI
                @else
                    NOVÁ UDÁLOST
                @endif
            </h5><button class="close" title="Zavřít" type="button"></button>
        </div>
        <div class="modal-body">
            <form action="{{isset($item) ? route('event.update',['id' => $item->id]) : route('event.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($item))
                    @method('put')
                @endif
                @if(isset($item) && $item->approved == 0)
                    <input type="hidden" name="not_approved">
                @endIf
                <div class="inputs flx-w row">
                    <div class="box-input w100">
                        <label for="misto">Název</label>
                        <input id="misto" name="name" type="text"  value="{{$item->title ?? ''}}">
                    </div>
                </div>

                <div class="inputs flx-w row">
                    <div class="box-input w100">
                        <label for="description">Popis akce</label>
                        <textarea id="description" class="mytextarea" name="description">{{$item->description ?? ''}}</textarea>
                    </div>
                </div>

                <div class="inputs flx-w row">
                    <div class="box-input w50">
                        <label for="district">Okres</label>
                    <select id="district" name="district" class="dependent-select-parent" data-child="#place" data-url="{{route('getDistrictPlaces')}}" data-token="{{csrf_token()}}">
                            @foreach(App\Model\District::all() as $district)
                                <option value="{{$district->id}}" {{isset($item->$district) && $item->district->id == $district->id ? "selected" : ''}}>{{$district->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="box-input w50">
                        @if(isset($item) && !isset($item->place_id))
                            {{-- Neni nastaveno misto, zobraz misto od uzivatele--}}
                            <label for="place_text">Místo od uživatele</label>
                            <input id="place_text" name="place_text" type="text" required="" value="{{$item->place_text ?? ''}}">
                        @else
                            {{--je nastaveno misto zobraz input pro vyber mist z okresu --}}
                                <label for="place">Místo</label>
                                <select id="place" name="place">
                                    {{-- tady bude vyhledavaci select --}}
                                    @if(isset($item))
                                        @foreach($item->district->places as $place)
                                            <option value="{{$place->id}}" {{isset($item->place) && $item->place->id == $place->id ? "selected" : ''}}>{{$place->name}}</option>
                                        @endforeach
                                    @else
                                        @if(App\Model\District::all()->first())
                                            @foreach(App\Model\District::all()->first()->places as $place)
                                                <option value="{{$place->id}}" {{isset($item) && $item->place->id == $place->id ? "selected" : ''}}>{{$place->name}}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                        @endif
                    </div>
                </div>

                @if(isset($item) && !isset($item->place_id))
                    <div class="inputs flx-w row">
                        <div class="box-input w50">
                        </div>
                        <div class="box-input w50">
                            <label for="place">Místo</label>
                            <select id="place" name="place">
                                {{-- tady bude vyhledavaci select --}}
                                @if(isset($item))
                                    @foreach($item->district->places as $place)
                                        <option value="{{$place->id}}" {{isset($item->$place) && $item->place->id == $place->id ? "selected" : ''}}>{{$place->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                @endif

                <div class="inputs flx-w row">
                    <div class="box-input datepicker-box w50">
                        <label for="date-start">Datum začátku</label>
                        <input class="datepick datepick-start" id="date-start" name="date-start" type="text" required="">
                    </div>
                    <div class="box-input w50">
                        <label for="time-start">Čas začátku</label>
                        <input id="time-start" name="time-start" type="text" class="timepick" required="" value="{{$item->name ?? ''}}">
                    </div>
                </div>

                <div class="inputs flx-w row">
                    <div class="box-input datepicker-box w50">
                        <label for="date-end">Datum konce</label>
                        <input class="datepick datepick-end" id="date-end" name="date-end" type="text" required="">
                    </div>
                    <div class="box-input w50">
                        <label for="time-end">Čas konce</label>
                        <input id="time-end" name="time-end" type="text" class="timepick" required="" value="{{$item->name ?? ''}}">
                    </div>
                </div>
                <div class="inputs flx-w row">
                    <div class="box-input w50">
                        <label for="category">Kategorie</label>
                        <select id="category" name="category">
                            @foreach(App\Model\Category::all() as $category)
                                <option value="{{$category->id}}" {{isset($item->$category) && $item->category->id == $category->id ? "selected" : ''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="box-input w50">
                        <label for="contact">Pořadatel</label>
                        <select id="contact" name="contact">
                            @foreach(App\Model\Contact::all() as $contact)
                                <option value="{{$contact->id}}" {{isset($item) && $item->contact->id == $contact->id ? "selected" : ''}}>{{$contact->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if(isset($item) && $item->images->count())
                    <div class="row">
                        <div class="images-wrapper">
                            <h5>Nahrané fotky</h5>
                            @foreach($item->images as $image)
                                <div class="image-wrapper">
                                    <img src="{{asset($image->thumbnail)}}" alt="obr">
                                    <button class="ac-btn remove-image" title="Smazat" data-tooltip="smazat" type="button" data-id="{{$image->id}}"><img src="{{asset('img/admin/remove.svg')}}" alt="Smazat"></button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="inputs flx-w row">
                    <div class="box-input w100">
                        <label for="image">Přidat fotku:</label>
                        <input class="image-input" type="file" accept="image/png, image/jpeg" name="images[]">
                        <input type="hidden" id="deleted-images" name="deleted-images">
                    </div>
                </div>

                <div class="inputs flx-w row">
                    <div class="box-input w100">
                        <button id="add-image" type="button" class="button">+</button>
                    </div>
                </div>

                <div class="center-button">
                    <button class="button" type="submit" name="button">ULOŽIT</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var dateStart, dateEnd, timeStart, timeEnd;
        @if(isset($item))
            dateStart = new Date({{$item->getDateFromMilliseconds()}});
            dateEnd = new Date({{$item->getDateToMilliseconds()}});
            timeStart = '{{$item->getFromTime()}}';
            timeEnd = '{{$item->getToTime()}}';
        @else
            dateStart = dateEnd = new Date();
            timeStart = timeEnd = '08:00';
        @endif

        $('#district').select2({width: '100%'});
        $('#category').select2({width: '100%'});
        $('#place').select2({width: '100%'});
        $('#contact').select2({width: '100%'});

        $(".datepick").datepicker({
            language: 'cs-CZ',
            minDate: 0,
        });
        console.log(dateStart);
        console.log(dateEnd);
        $(".datepick-start").datepicker('setDate', dateStart);
        $(".datepick-end").datepicker('setDate', dateEnd);

        var timePickerOptions = {
            timeFormat: 'HH:mm',
            interval: 30,
            minTime: '00',
            maxTime: '11 PM',
            defaultTime: timeStart,
            startTime: '06:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            zindex: 9999,
        };

        $('#time-start').timepicker(timePickerOptions);

        timePickerOptions.defaultTime = timeEnd;
        $('#time-end').timepicker(timePickerOptions);


    });
</script>