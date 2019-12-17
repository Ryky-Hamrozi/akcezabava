<div class="modal-handler" id="new-action-modal">
    <div class="modal-content">
        <div class="modal-header flx sb-c">
            <h5>
                @if(isset($item))
                    EDITACE KATEGORIE
                @else
                    NOVÁ KATEGORIE
                @endif
            </h5><button class="close" title="Zavřít" type="button"></button>
        </div>
        <div class="modal-body">
            <form action="{{isset($item) ? route('category.update',['id' => $item->id]) : route('category.store')}}" method="post">
                @csrf
                @if(isset($item))
                    @method('put')
                @endif
                <div class="inputs flx-w row">
                    <div class="box-input w50">
                        <label for="name">Název</label>
                        <input id="name" name="name" type="text"  value="{{$item->name ?? ''}}">
                    </div>
                    <div class="box-input w50">
                        <label for="foreColor">Barva textu</label>
                        <input id="foreColor" name="foreColor" type="color"  value="{{$item->foreColor ?? ''}}">
                    </div>
                    <div class="box-input w50">
                        <label for="backColor">Barva pozadí</label>
                        <input id="backColor" name="backColor" type="color"  value="{{$item->backColor ?? ''}}">
                    </div>
                    {{--
                    <div class="box-input w50">
                        <label for="okres">Okres</label>
                        <select id="okres" name="district">
                            @foreach(App\Model\District::all() as $district)
                                <option value="{{$district->id}}" {{isset($item) && $item->district->id == $district->id ? "selected" : ''}}>{{$district->name}}</option>
                            @endforeach
                        </select>
                    </div>--}}
                    {{--
                    <div class="box-input w50">
                        <label for="kontakt">Kontakt *</label>
                        <input id="kontakt" name="kontakt" type="text" required="">
                    </div>
                    <div class="box-input w50">
                        <label for="pocetakci">Akcí *</label>
                        <input id="pocetakci" name="pocetakci" type="number" required="">
                    </div>
                    --}}

                </div>
                <div class="center-button">
                    <button class="button" type="submit" name="button">ULOŽIT</button>
                </div>
            </form>
        </div>
    </div>
</div>