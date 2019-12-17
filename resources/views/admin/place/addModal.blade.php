<div class="modal-handler" id="new-action-modal">
    <div class="modal-content">
        <div class="modal-header flx sb-c">
            <h5>
                @if(isset($item))
                    EDITACE MÍSTA
                @else
                    NOVÉ MÍSTO
                @endif
            </h5><button class="close" title="Zavřít" type="button"></button>
        </div>
        <div class="modal-body">
            <form action="{{isset($item) ? route('place.update',['id' => $item->id]) : route('place.store')}}" method="post">
                @csrf
                @if(isset($item))
                    @method('put')
                @endif
                <div class="inputs flx-w row">
                    <div class="box-input w50">
                        <label for="misto">Místo *</label>
                        <input id="misto" name="name" type="text" value="{{$item->name ?? ''}}">
                    </div>
                    <div class="box-input w50">
                        <label for="okres">Okres</label>
                        <select id="okres" name="district">
                            @foreach(App\Model\District::all() as $district)
                                <option value="{{$district->id}}" {{isset($item) && $item->district->id == $district->id ? "selected" : ''}}>{{$district->name}}</option>
                            @endforeach
                        </select>
                    </div>
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