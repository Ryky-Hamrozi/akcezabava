<div class="new-action-page">
    {{--
    <div class="facebook-part flx-w sb-c">
        <div class="left-side">
            <h1>Propojit s facebookem</h1>
            <div class="inputs flx-w row">
                <div class="box-input">
                    <input id="fb" name="fb" type="text" >
                    <label for="fb">facebook odkaz</label>
                </div>
            </div>
            <button class="fb-btn" type="submit" name="button">nahrát</button>
        </div>
        <img src="img/logofb.png" alt="facebook">
    </div>
    --}}
    <h2>Vložit vlastní obsah</h2>

    @include('front.errors')

    <form method="post" action="{{route('process-event')}}" id="js-add-event-form" enctype="multipart/form-data">
        @csrf
        <div class="inputs flx-w row">
            <div class="box-input w33p">
                <input id="newaction" name="name" type="text" @if(isset($request))value="{{$request['name']}}"@endif>
                <label for="newaction">NÁZEV AKCE</label>
            </div>
            <div class="box-input w33p">
                <input id="place" name="user_place" type="text" @if(isset($request))value="{{$request['user_place']}}"@endif >
                <label for="place">místo</label>
            </div>
            <div class="box-input w33p">
                <select name="district" id="district">
                    @foreach($districts as $district)
                        <option value="{{$district->id}}">{{$district->name}}</option>
                    @endforeach
                </select>
                <label for="district">vyberte okres</label>
            </div>
            <div class="box-input w33p">
                <input id="person" name="person" type="text" @if(isset($request))value="{{$request['person']}}"@endif >
                <label for="person">Kontaktní osoba</label>
            </div>
            <div class="box-input w33p">
                <input id="email" name="email" type="email" @if(isset($request))value="{{$request['email']}}"@endif >
                <label for="email">E-mail</label>
            </div>
            <div class="box-input w33p">
                <input id="phone" name="phone" type="tel" @if(isset($request))value="{{$request['phone']}}"@endif >
                <label for="phone">Telefon</label>
            </div>
            <div class="box-input w50p">
                <input id="date-start" name="date-start" type="text" class="datepick datepick-start" @if(isset($request))value="{{$request['date-start']}}"@endif>
                <label for="date-start">Datum začátku</label>
            </div>
            <div class="box-input w50p">
                <input id="time-start" name="time-start" type="text" @if(isset($request))value="{{$request['time-start']}}"@endif>
                <label for="time-start">Čas začátku</label>
            </div>
            <div class="box-input w50p">
                <input id="date-end" name="date-end" type="text" class="datepick datepick-end" @if(isset($request))value="{{$request['date-end']}}"@endif>
                <label for="date-end">Datum konce</label>
            </div>
            <div class="box-input w50p">
                <input id="time-end" name="time-end" type="text" @if(isset($request))value="{{$request['time-end']}}"@endif>
                <label for="time-end">Čas konce</label>
            </div>
            <div class="box-input w50p">
                <textarea id="dsc" name="description" @if(isset($request))value="{{$request['description']}}"@endif></textarea>
                <label for="dsc">Popis akce</label>
            </div>
            <div class="box-input w50p">
                <input id="uplaod" name="images[]" type="file" >
                <label for="uplaod">plakát k akci</label>
            </div>
        </div>
        <div class="buttons flx sb-c">
            <button class="button green" type="submit">odeslat ke schválení</button>
            <a class="button back" href="/"><img src="{{asset('img/front/ar-l.svg')}}" alt="ZPĚT NA WEB">ZPĚT NA WEB</a>
        </div>
    </form>
</div>
