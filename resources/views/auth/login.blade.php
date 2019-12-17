<!doctype html>
<html lang="cs-CZ" prefix="og: http://ogp.me/ns#">
<head>
    <title>Admin | @yield('title')</title>

    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content=""/>
    <meta name="keywords" content="HTML,CSS,XML,JavaScript"/>
    <meta name="author" content="LEKSYS s.r.o. www.leksys.cz"/>

    <link rel="stylesheet" media="screen" href="{{asset('css/admin/style.css')}}"/>
    <link rel="stylesheet" media="screen" href="{{asset('css/admin/devices.css')}}"/>
    <link rel="stylesheet" media="screen" href="{{asset('css/admin/jquery-ui.min.css')}}">


    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">

    <script src="{{asset('js/admin/jquery-2.1.4.js')}}"></script>
    <script src="{{asset('js/admin/jquery-ui.min.js')}}"></script>
    <script src="{{asset('https://www.gstatic.com/charts/loader.js')}}"></script>
    <script src="{{asset('js/admin/web.js')}}"></script>
    <script src="{{asset('js/admin/functionality.js')}}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <meta property="og:locale" content="cs_CZ">
    <meta property="og:url" content="">
    <meta property="og:type" content="website">
    <meta property="og:title" content="">
    <meta property="og:description" content="Lorem ipsum dolor sit amet">
    <meta property="og:image" content="">
    <meta property="og:site_name" content="">

</head>


<body>

<div class="login-form-wrapper">
    <div class="container center">
        <h5>
            Administrace
        </h5>
        <form action="{{route('processLogin')}}" method="post">
            @csrf

            <div class="inputs flx-w row">
                <div class="box-input">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email">
                </div>
            </div>

            <div class="inputs flx-w row">
                <div class="box-input">
                    <label for="password">Heslo</label>
                    <input type="password" id="password" name="password">
                </div>
            </div>

            <div class="">
                <button class="button" type="submit" name="button">Přihlásit se</button>
            </div>

        </form>
    </div>
</div>
<div class="overlay"></div>
<button title="Nahoru" type="button" class="scrollToTop"><span>Nahoru</span><i></i></button>
</body>
</html>

