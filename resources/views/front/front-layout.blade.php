<!doctype html>
<html lang="cs-CZ" prefix="og: http://ogp.me/ns#">
<head>
    <title>@yield('title')</title>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="" />
    <meta name="keywords" content="HTML,CSS,XML,JavaScript" />
    <meta name="author" content="LEKSYS s.r.o. www.leksys.cz" />

    <link rel="stylesheet" media="screen" href="{{asset('css/front/style.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('css/front/devices.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('css/front/jquery-ui.min.css')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('css/admin/select2.min.css')}}" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans:400,600,700&display=swap" rel="stylesheet">

    <script src="{{asset('js/admin/jquery-2.1.4.js')}}"></script>
    <script src="{{asset('js/front/slick.min.js')}}"></script>
    <script src="{{asset('js/admin/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/admin/select2.full.min.js')}}"></script> 
    <script src="{{asset('js/front/web.js')}}"></script>
 
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <meta property="og:locale"       content="cs_CZ">
    <meta property="og:url"          content="">
    <meta property="og:type"         content="website">
    <meta property="og:title"        content="">
    <meta property="og:description"  content="Lorem ipsum dolor sit amet">
    <meta property="og:image"        content="">
    <meta property="og:site_name"    content="">

    <link rel="canonical" href="#">

</head>
<body>
<!-- JSON LD START -->
<script type="application/ld+json">
    {
      // Social sites
      "logo": "https://www..cz/img/logo.png"
      "@context": "http://schema.org",
      "@type": "Organization",
      "url": "https://www..cz/",
      "contactPoint": [{
        "@type": "ContactPoint",
        "telephone": "",
        "contactType": "customer service"
      },{
        "@type": "ContactPoint",
        "telephone": "",
        "contactType": "customer service"
      }],
      // Contact
      "name": "",
      "sameAs": [
        "", ""
      ],
      // Address
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "",
        "addressLocality": "",
        "addressRegion": "Česká republika"
      }
    }
    </script>
<!-- JSON LD END -->
<div class="background-fixed"> <!--  trida static  -->
    <a id="backgroundstatic" href="#"></a>
    <div class="ios-wrap">
        <div class="container">
            <header class="flx sb-c">
                <a class="logo" href="/"><img src="{{asset('img/front/logo.png')}}" alt="Logo"></a>
                <div class="right-side flx-c">
                    <a class="menu-btn" href="" title="AKCE A ZÁBAVA"><img src="{{asset('img/front/hipe.svg')}}" alt="AKCE A ZÁBAVA">AKCE A ZÁBAVA</a>
                   {{-- <a class="menu-btn" href="" title="KINA V OKOLÍ"><img src="{{asset('img/front/camera.svg')}}" alt="KINA V OKOLÍ">KINA V OKOLÍ</a> --}}
                    <a class="button" href="{{route('new-event')}}">Vložit událost</a>
                </div>
            </header>
        </div>

        <div class="container">

            @yield('content')




        <div class="container">
            <footer class="flx-w">
                <div>
                    <h3>O PROJEKTU</h3>
                    <ul>
                        <li><a href="{{route('about-us')}}">O nás</a></li>
                        <li><a href="{{route('advertising')}}">Obchodní formulář</a></li>
                        <li><a href="{{route('how-it-works')}}">Jak to funguje</a></li>
                        <li><a href="">Vložit akci</a></li>
                    </ul>
                </div>
                <div>
                    <h3>KONTAKT</h3>
                    <p>Tomáš Gottwald</p>
                    <p>Blažejské nám. 7</p>
                    <p>Olomouc 77900</p>
                </div>
                <div>
                    <h3>OBCHODNÍ ÚDAJE</h3>
                    <p>Jana Foretníková</p>
                    <p>Blažejské nám. 7</p>
                    <p>Olomouc 77900</p>
                </div>
                <div class="socials">
                    <a class="social" title="Facebook" href=""><img src="{{asset('img/front/facebook.svg')}}" alt="Facebook"></a>
                    <a class="social" title="Instagram" href=""><img src="{{asset('img/front/instagram.svg')}}" alt="Instagram"></a>
                </div>
                <div class="copyright flx sb-c">
                    <p>© 2019 akcezabava.cz</p><p>by<a target="_blank" title="LEKSYS" href="https://www.leksys.cz/"><img src="{{asset('img/front/logoleksys.svg')}}" alt="LEKSYS"></a></p>
                </div>
            </footer>
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
    $(".datepick").datepicker({
        language: 'cs-CZ',
        minDate: 0
    });
</script>
@yield('scripts')
<div class="overlay"></div>
<button title="Nahoru" type="button" class="scrollToTop"><span>Nahoru</span><i></i></button>
</body>
</html>
