@extends('front.front-layout')

@section('title', $event->title)

@section('content')

    <ul class="breadcrumb">
        <li><a href="{{route('home')}}">Úvod</a></li>
        <li><a href="{{route('list-event')}}">akce</a></li>
        <li><a href="">volný čas a zábava</a></li>
    </ul>
    <div class="detail-page flx-w">
        <div class="center">
            @if($event->getMainImage())
            <?php
                $tempImageDetailEvent = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
                        \App\Model\ImageGenerator::CONF_EVENT_DETAIL,
                        $event->id,
                        $event->getMainImage()
                );
            ?>
            <div class="nahled"><img src="{{asset($tempImageDetailEvent)}}" alt="nahled"></div>
            @endif
            <h1>{{$event->title}}</h1>

            <div class="catch-the-image"></div>
            <div class="tag"
                 style="background: {{$event->category->backColor}}; color: {{$event->category->foreColor}}">{{$event->category->name}}</div>
            <ul class="maindsc">
                <li><img src="{{asset('img/front/datered.svg')}}" alt="Datum">{{$event->getFormatedDate()}}</li>
                <li><img src="{{asset('img/front/placered.svg')}}" alt="Místo">{{$event->place->name}}</li>
                @if($event->fb_url)
                    <li><img src="{{asset('img/front/sharered.svg')}}" alt="Adresa"><a
                                href="{{$event->fb_url}}" target="_blank">{{$event->fb_url}}</a></li>
                @endif
            </ul>
        </div>
        <div class="left-side">
            {{--<a class="button share" title="" href="">Sdílet událost <span><img src="{{asset('img/front/share.svg')}}" alt="Share"></span></a>--}}
            <div class="description">
                {!!$event->description!!}
                {{--
                <p><strong>UV Color Party- VARNA 12.7.2017</strong></p>
                <p>Opět naše jedinečná UV Color Party je spojením našich skvělých projektů do jedné ještě lepší párty a zábava jakou si zaslouží právě Olomouc. Přijď oblečen/a v bílém, dostaneš welcome drink (jak je u nás dobrým zvykem) a na to, co zažiješ v klubu v životě nezapomeneš. UV děla, UV výzdoba, UV doplňky, lasery a samozřejmě UV barvy na tělo nebudou chybět.</p>
                <h2>SINED</h2>
                <p>Sined je DJ&Producer pocházející ze Slovenska. Jeho výběr tracků energické provedení uspokojí každého návštěvníka párty když se věnuje všem stylům house music. Před každou párty se poctivě připravuje a chystá si vlastní mashupy & edity.
                Věnuje se i vlastní produkci, jeho tracky byli vydané na jednom z TOP českém vydavatelství Bohemian Recordings & na slovenském vydavatelství Active Melody Records. Na léto chystá
                nové tracky, novou show a za vzpomenutí stojí určite i Ľadovo fest, kde se představí spolu se Slovenskou djskou TOPkou DJ EKG, Milan Lieskovsky, Emtydee atd.</p>
                <p>Facebook fanpage - <a href="">https://www.facebook.com/sinedofficial/</a></p>
                <p>Instagram - <a href="">https://www.instagram.com/sinedkoo/</a></p>
                <p>Soundcloud - <a href="">https://soundcloud.com/sined-official</a></p>
                <h2>ŠTEFI</h2>
                <p>-Fanpage: <a href="">https://www.facebook.com/DJ-ŠTEFI-538792999551963/?fref=ts</a></p>
                <p>Ondřej Štefka je talentovaný DJ z Malenovic, který prakticky nezná žádné meze a za mixem se s tím nikdy nemazlí! Electro House, Future a Jungle Terror, přesně tohle nás od Štefiho čeká. ŠTEFI JE V SOUČASNÉ DOBĚ I RESIDENTNÍ DJ V PROJEKTU CARNIVAL HOUSE EVENTS!</p>
                <h2>NA CO SE MŮŽETE TĚŠIT?!</h2>
                <ul>
                  <li>UV DĚLA</li>
                  <li>UV PARTY DOPLŇKY</li>
                  <li>UV BARVY NA TĚLO</li>
                  <li>SEXY HOSTESKA</li>
                  <li>CHILL OUT STAGE</li>
                  <li>WELCOME DRINKY</li>
                  <li>GRILL BAR</li>
                  <li>2 STAGE</li>
                  <li>AKCE NA 4. BARECH</li>
                </ul>
                <h2>Akční drinky</h2>
                <ul>
                  <li>BRZY DOPLNÍME!</li>
                </ul>
                <div class="soutez">
                  <h3>Soutěž VOLNÉ VSTUPY</h3>
                  <p>1) Pozvi své FB přátele na událost a událost sdílej.</p>
                  <p>2) Napiš na zeď události: „Hotovo, pozvané!“.</p>
                  <p>11.7. ve 20:00 vylosujeme výherce!</p>
                </div>
                <div class="soutez">
                  <h3>Soutež 500kč na BAR</h3>
                  <p>Zavěs na událost Party song, sežeň si co najvíc lajků a výhra je Tvoje! (soutež 18+)</p>
                  <p>11.7. ve 20:00 vylosujeme výherce!</p>
                </div>
                <h2>VSTUPNÉ</h2>
                <p>Akce je 16+</p>
                <p>VSTUP DO CLUBU: 60,- / osoba</p>
                <a href="#" class="reklama"><img src="{{asset('img/front/reklama3.jpg')}}" alt="reklama"></a>
                --}}
            </div>
        </div>

        <div class="right-side">
            @if($eventBanner)
                <?php
                if($eventBanner->getImagePath()) {
                    $tempBannerDetail = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
                            \App\Model\ImageGenerator::CONF_BANNER_EVENT_DETAIL,
                            $eventBanner->id,
                            $eventBanner->getImagePath()
                    );
                }
                ?>
                <a href="#" class="reklama"><img src="{{$tempBannerDetail}}" alt="reklama"></a>
            @endif
        </div>

    </div>

    <section class="similar-actions ds">
        <h2 class="title">Podobné akce</h2>

        <div class="flx-w row">
            @foreach($similarEvents as $event)
                @include('front.event.components.eventThumbnail',['event' => $event])
            @endforeach
        </div>
    </section>
    </div>

@endsection
