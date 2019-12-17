@extends('front.front-layout')

@section('title', 'O nás')

@section('content')
    <div class="new-action-page about-us">
        <h1>Kdo jsme</h1>
        <div class="flx-w sb-c">
            <div class="dsc">
                <span>AkceZabava.cz</span> je projektem Radia Haná. Naším cílem je poskytovat na jediném místě nejširší nabídku volnočasových aktivit. Informujeme tedy o akcích kulturního, společenského, sportovního a vzdělávacího charakteru z Olomouckého kraje a blízkého okolí. Jsme tu pro Vás a spolu můžeme prezentovat všechny akce ve vašich městech či obcích, např. ve Vašem oblíbeném kině, divadle, kulturním domě, na stadionu, náměstí a dalších místech, co Vás jen napadnou. Víte o akci, která si zaslouží pozornost lidí? Napište nám, anebo ji představte sami na našich společných stránkách AkceZabava.cz.
            </div>
            <img src="{{asset('img/front/hana.png')}}" alt="Radio Hana">
        </div>
        <div class="map">
            <div class="info-map">
                <h2>Napište nám</h2>
                <hr>
                <p>Blažejské nám. 7</p>
                <p>Olomouc</p>
                <p>77900</p>
                <div class="contact">
                    <img src="{{asset('img/front/email.svg')}}" alt="email">
                    <a href="mailto:info@akcezabava.cz">info@akcezabava.cz</a>
                    <a href="mailto:obchod@akcezabava.cz">obchod@akcezabava.cz</a>
                </div>
                <div class="contact">
                    <img src="{{asset('img/front/telephone.svg')}}" alt="telephone">
                    <p>+420 774 542 627</p>
                    <p>+420 777 742 623</p>
                </div>
                <div class="socials">
                    <a class="social" title="Facebook" href=""><img src="{{asset('img/front/facebook.svg')}}" alt="Facebook"></a>
                    <a class="social" title="Instagram" href=""><img src="{{asset('img/front/instagram.svg')}}" alt="Instagram"></a>
                </div>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d646.5893161330653!2d17.254817829262752!3d49.59101186806726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47124e8a89d04435%3A0xf8f35576ed9bb2f9!2zUsOhZGlvIEhhbsOhIFMuci5vLg!5e0!3m2!1scs!2scz!4v1561533841345!5m2!1scs!2scz" allowfullscreen=""></iframe>
        </div>
    </div>


@endsection