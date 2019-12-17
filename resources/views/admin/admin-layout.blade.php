<!doctype html>
<html lang="cs-CZ" prefix="og: http://ogp.me/ns#">
<head>
    <title>Admin | @yield('title')</title>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="" />
    <meta name="keywords" content="HTML,CSS,XML,JavaScript" />
    <meta name="author" content="LEKSYS s.r.o. www.leksys.cz" />

    <link rel="stylesheet" media="screen" href="{{asset('css/admin/style.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('css/admin/devices.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('css/admin/jquery-ui.min.css')}}">


    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">

    <script src="{{asset('js/admin/jquery-2.1.4.js')}}"></script>
    <script src="{{asset('js/admin/jquery-ui.min.js')}}"></script>
    <script src="{{asset('https://www.gstatic.com/charts/loader.js')}}"></script>
    <script src="{{asset('js/admin/web.js')}}"></script>
    <script src="{{asset('js/admin/functionality.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/admin/tinymce/tinymce.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/admin/tinymce/jquery.tinymce.min.js')}}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <meta property="og:locale"       content="cs_CZ">
    <meta property="og:url"          content="">
    <meta property="og:type"         content="website">
    <meta property="og:title"        content="">
    <meta property="og:description"  content="Lorem ipsum dolor sit amet">
    <meta property="og:image"        content="">
    <meta property="og:site_name"    content="">

    <link rel="icon" type="image/png" href="{{asset("img/favicon-32x32.png")}}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{asset("img/favicon-16x16.png")}}" sizes="16x16" />

</head>
<body>
<div class="ios-wrap">
    <aside>
        <a class="logo" href=""><img src="{{asset('img/admin/logo.png')}}" alt="logo"></a>
        <p class="last-activity">{{--Naposledy aktivní <strong>17.5.2017 | 17:53</strong>--}}</p>
        <nav>
            <ul>
                <li class="{{Request::is('admin/dashboard') ? 'active' : ''}}"><a href="/admin/dashboard">PŘEHLED</a></li>
                <li class="has-sub {{Request::is('admin/event','admin/event/for-approval','admin/event/finished','admin/event/upcoming') ? 'active' : ''}}">
                    <a href="/admin/event">AKCE</a>
                    <ul class="submenu">
                        <li class="{{Request::is('admin/event') ? 'active' : ''}}"><a href="/admin/event">Všechny</a></li>
                        <li class="{{Request::is('admin/event/for-approval') ? 'active' : ''}}"><a href="/admin/event/for-approval">Ke schválení <span>25</span></a></li>
                        <li class="{{Request::is('admin/event/finished') ? 'active' : ''}}"><a href="/admin/event/finished">Ukončené</a></li>
                        <li class="{{Request::is('admin/event/upcoming') ? 'active' : ''}}"><a href="/admin/event/upcoming">Připravované</a></li>
                    </ul>
                </li>
                <li class="{{Request::is('admin/contact') ? 'active' : ''}}"><a href="/admin/contact">KONTAKTY</a></li>
                <li class="has-sub {{Request::is('admin/category','admin/district') ? 'active' : ''}}"><a href="/admin/category">STATISTIKY</a>
                    <ul class="submenu">
                        {{--<li><a href="">Klíčová slova</a></li>--}}
                        <li class="{{Request::is('admin/category') ? 'active' : ''}}"><a href="/admin/category">Kategorie</a></li>
                        <li class="{{Request::is('admin/district') ? 'active' : ''}}"><a href="/admin/district">Okresy</a></li>
                    </ul>
                </li>
                <li class="{{Request::is('admin/place') ? 'active' : ''}}"><a href="/admin/place">MÍSTA</a></li>
                <li class="{{Request::is('admin/banner') ? 'active' : ''}}"><a href="/admin/banner">BANNERY</a></li>
                {{--<li><a href="">UŽIVATELÉ</a></li>--}}
            </ul>
        </nav>
    </aside>
    <main>
        <header>
            <div class="container flx sb-c">
                <form class="searching flx" action="">
                    <input type="text" placeholder="Vyhledávání..." required>
                    <button type="submit"></button>
                </form>
                <div class="right-content flx-c">
                    <a class="user flx-c">
                        <span class="name"><strong>Michal Orsava</strong>systém administrátor</span><img src="{{asset('img/admin/user.svg')}}" alt="User">
                    </a>
                    <div class="spinner-master">
                        <input type="checkbox" id="spinner-form" />
                        <label for="spinner-form" class="spinner-spin">
                            <span class="spinner diagonal part-1"></span>
                            <span class="spinner horizontal"></span>
                            <span class="spinner diagonal part-2"></span>
                        </label>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-content">
            <div class="container {{Request::is('admin/dashboard') ? 'flx-w row' : '' }}">
                @include('flash::message')
                @if($errors)                   
                    <div>
                        @foreach($errors->all() as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    </div>
                @endif                
                @yield('content')
            </div>
        </div>

        <footer>
            <div class="container flx sb-c">
                <p>© 2019 akcezabava.cz</p>
                <p>by <a href=""><img src="{{asset('img/admin/logo_leksys.svg')}}" alt="leksys" /></a></p>
            </div>
        </footer>
    </main>
</div>
{{--
<!-- Modal okno editace akce -->
<div class="modal-handler" id="nahled">
    <div class="modal-content">
        <div class="modal-header flx sb-c">
            <h5>Upravit akci</h5><button class="close" title="Zavřít" type="button"></button>
        </div>
        <div class="modal-body">
            <form action="">
                <div class="inputs flx-w row">
                    <div class="box-input">
                        <label for="jmeno2">Jméno *</label>
                        <input id="jmeno2" name="jmeno2" type="text" value="Ing. Simona Zabáková" required>
                    </div>
                    <div class="box-input w50">
                        <label for="firma2">Firma</label>
                        <input id="firma2" name="firma2" type="text" value="Synagoga Hranice">
                    </div>
                    <div class="box-input w50">
                        <label for="okres2">Okres</label>
                        <select id="okres2" name="okres2">
                            <option value="">Hranice</option>
                            <option value="">Olomoucky</option>
                            <option value="">Ipsum</option>
                        </select>
                    </div>
                    <div class="box-input datepicker-box w50">
                        <label for="telefon2">Telefon</label>
                        <input name="telefon2" id="telefon2" type="tel" value="777 258 789" required>
                    </div>
                    <div class="box-input w50">
                        <label for="email2">Email *</label>
                        <input id="email2" name="email2" type="text" value="zalabakova@gmail.com">
                    </div>
                    <div class="box-input w50">
                        <label for="akci">Akcí *</label>
                        <input id="akci" name="akci" type="number" value="25">
                    </div>
                </div>
                <div class="center-button">
                    <button class="button" type="submit" name="button">ULOŽIT</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal okno pridani akce -->
<div class="modal-handler" id="new-action-modal">
    <div class="modal-content">
        <div class="modal-header flx sb-c">
            <h5>NOVÉ MÍSTO</h5><button class="close" title="Zavřít" type="button"></button>
        </div>
        <div class="modal-body">
            <form action="">
                <div class="inputs flx-w row">
                    <div class="box-input w50">
                        <label for="misto">Místo *</label>
                        <input id="misto" name="misto" type="text" required>
                    </div>
                    <div class="box-input w50">
                        <label for="okres">Okres</label>
                        <select id="okres" name="okres">
                            <option value="">Olomoucky</option>
                            <option value="">Lorem</option>
                            <option value="">Impsum</option>
                        </select>
                    </div>
                    <div class="box-input w50">
                        <label for="kontakt">Kontakt *</label>
                        <input id="kontakt" name="kontakt" type="text" required>
                    </div>
                    <div class="box-input w50">
                        <label for="pocetakci">Akcí *</label>
                        <input id="pocetakci" name="pocetakci" type="number" required>
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
    // cze language
    $.datepicker.regional['cs'] = {
        closeText: 'Cerrar',
        prevText: 'Předchozí',
        nextText: 'Další',
        currentText: 'Hoy',
        monthNames: ['Leden','Únor','Březen','Duben','Květen','Červen', 'Červenec','Srpen','Září','Říjen','Listopad','Prosinec'],
        monthNamesShort: ['Le','Ún','Bř','Du','Kv','Čn', 'Čc','Sr','Zá','Ří','Li','Pr'],
        dayNames: ['Neděle','Pondělí','Úterý','Středa','Čtvrtek','Pátek','Sobota'],
        dayNamesShort: ['Ne','Po','Út','St','Čt','Pá','So',],
        dayNamesMin: ['Ne','Po','Út','St','Čt','Pá','So'],
        weekHeader: 'Sm',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    // cze init
    $.datepicker.setDefaults($.datepicker.regional['cs']);
    // datepicker cfg
    $("#datum").datepicker({
        language: 'cs-CZ',
        minDate: 0
    });
</script>

<div class="modal-handler" id="remove">
    <div class="modal-content">
        <div class="modal-header flx sb-c">
            <h5>SMAZAT AKCI</h5><button class="close" title="Zavřít" type="button"></button>
        </div>
        <div class="modal-body">
            <form action="remove-term">
                <p class="center">Opravdu si přejete akci odstranit?</p>
                <div class="text-al-ri flx sb-c">
                    <button title="odstranit akci" type="submit" class="button remove">odstranit akci</button>
                    <button title="ZAVŘÍT" type="button" class="button grey close">ZAVŘÍT</button>
                </div>
            </form>
        </div>
    </div>
</div>
--}}
@yield('post-footer')

<div class="overlay"></div>
<button title="Nahoru" type="button" class="scrollToTop"><span>Nahoru</span><i></i></button>
</body>
</html>
