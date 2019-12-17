@extends('front.front-layout')

@section('title', 'Nová událost')

@section('content')

    <div class="new-action-page">
    {{--
    <div class="facebook-part flx-w sb-c">
        <div class="left-side">
            <h1>Propojit s facebookem</h1>
            <div class="inputs flx-w row">
                <div class="box-input">
                    <input id="fb" name="fb" type="text" required="">
                    <label for="fb">facebook odkaz</label>
                </div>
            </div>
            <button class="fb-btn" type="submit" name="button">nahrát</button>
        </div>
        <img src="img/logofb.png" alt="facebook">
    </div>
    --}}
        <h2>Vložit vlastní obsah</h2>

        @if($errors)
            <div>
                @foreach($errors->all() as $message)
                    <p>{{$message}}</p>
                @endforeach
            </div>
        @endif

        <form method="post" action="{{route('process-event')}}" enctype="multipart/form-data">
            @csrf
            <div class="inputs flx-w row">
                <div class="box-input w33p">
                    <input id="newaction" name="name" type="text" required="">
                    <label for="newaction">NÁZEV AKCE</label>
                </div>
                <div class="box-input w33p">
                    <input id="place" name="user_place" type="text" required="">
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
                    <input id="person" name="person" type="text" required="">
                    <label for="person">Kontaktní osoba</label>
                </div>
                <div class="box-input w33p">
                    <input id="email" name="email" type="email" required="">
                    <label for="email">E-mail</label>
                </div>
                <div class="box-input w33p">
                    <input id="phone" name="phone" type="tel" required="">
                    <label for="phone">Telefon</label>
                </div>
                <div class="box-input w50p">
                    <input id="date-start" name="date-start" type="text" class="datepick datepick-start" required="">
                    <label for="date-start">Datum začátku</label>
                </div>
                <div class="box-input w50p">
                    <input id="time-start" name="time-start" type="text" required="">
                    <label for="time-start">Čas začátku</label>
                </div>
                <div class="box-input w50p">
                    <input id="date-end" name="date-end" type="text" class="datepick datepick-end" required="">
                    <label for="date-end">Datum konce</label>
                </div>
                <div class="box-input w50p">
                    <input id="time-end" name="time-end" type="text" required="">
                    <label for="time-end">Čas konce</label>
                </div>
                <div class="box-input w50p">
                    <textarea id="dsc" name="description" required=""></textarea>
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

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            var dateEnd, timeEnd ;
            var dateStart = dateEnd = new Date();
            var timeStart =  timeEnd = '08:00';


            $('#district').select2(
                {   width: '100%',
                    containerCss : {'margin-top' : '20px', 'z-index' : '10'}
                });

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
@endsection

