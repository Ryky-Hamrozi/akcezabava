<h1 class="title"><span>Chcete reklamu</span> na našem webu?</h1>
@include('front.errors')
<form method="post" action="{{route('process-advertising')}}" enctype="multipart/form-data" id="js-reklama-na-webu-form">
    @csrf
    <div class="inputs flx-w row">
        <div class="box-input w33p">
            <input id="person" name="person" type="text" @if(isset($request))value="{{$request['person']}}"@endif >
            <label for="person">Jméno a příjmení</label>
        </div>
        <div class="box-input w33p">
            <input id="email" name="email" type="email" @if(isset($request))value="{{$request['email']}}"@endif>
            <label for="email">E-mail</label>
        </div>
        <div class="box-input w33p">
            <input id="phone" name="phone" type="tel" @if(isset($request))value="{{$request['phone']}}"@endif>
            <label for="phone">Telefon</label>
        </div>
        <div class="box-input w50p">
            <textarea id="dsc" name="dsc" @if(isset($request))value="{{$request['dsc']}}"@endif></textarea>
            <label for="dsc">popis navrhované spolupráce</label>
        </div>
        <div class="box-input w50p">
            <input id="uplaod" name="upload" type="file">
            <label for="uplaod">nahrajte přílohu</label>
        </div>
    </div>
    <div class="center-button flx sb-c">
        <button class="button green" type="submit">odeslat</button>
    </div>
</form>