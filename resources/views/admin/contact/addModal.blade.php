<div class="modal-handler" id="new-action-modal">
    <div class="modal-content">
        <div class="modal-header flx sb-c">
            <h5>
                @if(isset($item))
                    EDITACE KONTAKTU
                @else
                    NOVÝ KONTAKT
                @endif
            </h5><button class="close" title="Zavřít" type="button"></button>
        </div>
        <div class="modal-body">
            <form action="{{isset($item) ? route('contact.update',['id' => $item->id]) : route('contact.store')}}" method="post">
                @csrf
                @if(isset($item))
                    @method('put')
                @endif
                <div class="inputs flx-w row">
                    <div class="box-input w50">
                        <label for="name">Jméno *</label>
                        <input id="name" name="name" type="text"  value="{{$item->name ?? ''}}">
                    </div>

                    <div class="box-input w50">
                        <label for="company">Firma</label>
                        <input id="company" name="company" type="text"  value="{{$item->company ?? ''}}">
                    </div>

                    <div class="box-input w50">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email"  value="{{$item->email ?? ''}}">
                    </div>

                    <div class="box-input w50">
                        <label for="phone">Telefon</label>
                        <input id="phone" name="phone" type="text"  value="{{$item->phone ?? ''}}">
                    </div>

                    <div class="box-input wcompany">
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