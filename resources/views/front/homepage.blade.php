@extends('front.front-layout')

@section('title', 'Úvod')

@section('content')

    <main class="main-section">
        <h1><strong>Objevujte</strong>, co se děje ve vašem regionu</h1>

        <p>Nehledejte složitě na facebooku, vše najdete u nás! Přehledně a na jednom místě.</p>

        <div class="full-search">
            <form action="" class="flx">
                <div class="calcw flx">
                    <select name="" id="">
                        <option value="0">Všechny okresy</option>
                        @foreach($districts as $district)
                            <option value="{{$district->id}}">{{$district->name}}</option>
                        @endforeach
                    </select>

                    <div class="datepicker-box"><input class="datepick" type="text" placeholder="Kdykoliv"
                                                       id="dp1569323369937"></div>
                    <select name="" id="">
                        <option value="">Všechny druhy akcí</option>
                        @foreach($allCategories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                {{--<button class="pridat" type="button" name="rozsirene" title="Rozšířené hledání"></button>--}}
                <button class="hledat" type="submit" name="vyhledat" title="Vyhledat"></button>
            </form>
        </div>
    </main>

    <section class="recomended-for-u ds">
        <h1 class="title"><span>Vybrali jsme</span> pro vás</h1>

        <div class="slider flx-w arrows">
            @foreach($carouselBanners as $banner)
                @php($event = $banner->event()->first())
                <article>
                    <a href="" class="article big">
                        <figure>
                            <figcaption>
                                <h2>{{$event->title}}</h2>

                                <div class="tag" style="background: #2d7bf0;">{{$event->category->name}}</div>
                                <p class="date"><img src="{{asset("img/front/date.svg")}}" alt="">{{$event->getFormatedDate()}}</p>

                                <p class="place"><img src="{{asset("img/front/place.svg")}}" alt="">{{$event->place->name}}</p>

                                <div class="dsc">{{$event->description}}</div>
                            </figcaption>
                            <?php
                                if($banner->getImagePath()) {
                                    $tempImagePath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
                                        \App\Model\ImageGenerator::CONF_BANNER_HOMEPAGE_CAROUSEL,
                                        $banner->id,
                                        $banner->getImagePath()
                                    );
                                }
                            ?>
                            <div class="box" style="background-image:url({{asset($tempImagePath)}})"></div>
                        </figure>
                    </a>
                </article>
            @endforeach

        </div>

    </section>

    <section class="interested-actions ds">
        <h2 class="title"><span>Další</span> zajímavé akce</h2>
        <ul class="tabs tab-menu flx">
            <li class="{{$categoryId ? '' : 'active' }}"><a href="/">Vše</a></li>
            @foreach($categories as $category)
                <li class="{{$categoryId == $category->id  ? 'active' : '' }}"><a
                            href="{{route('home',['category' => $category->id])}}">{{$category->name}}</a></li>
            @endforeach
        </ul>
        <div class="tabs-content">
            <div class="tab-content open" id="all">
                <div class="flx-w row">

                    @foreach($events as $event)
                        @include('front.event.components.eventThumbnail',['event' => $event])
                    @endforeach

                    @foreach($actionBanner as $banner)
                    <article class="p15 w33p reklama-prc">
                        <a href="" class="article">
                            <?php
                            $actionBannerPath = "";
                            if($banner->getImagePath()) {
                                $actionBannerPath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
                                        \App\Model\ImageGenerator::CONF_BANNER_HOMEPAGE_ACTION,
                                        $banner->id,
                                        $banner->getImagePath()
                                );
                             }
                            ?>
                            <div class="box" style="background-image:url({{asset($actionBannerPath)}}})"></div>
                        </a>
                    </article>
                    @endforeach
                </div>
            </div>
            <div class="tab-content" id="gastonomie">a</div>
            <div class="tab-content" id="sport">b</div>
            <div class="tab-content" id="kultura">c</div>
            <div class="tab-content" id="volnycas">d</div>
            <div class="tab-content" id="vzdelavani">e</div>
            <div class="tab-content" id="ostatni">f</div>
            <div class="center-button"><a class="button" href="">načíst další akce</a></div>
        </div>
    </section>





@endsection