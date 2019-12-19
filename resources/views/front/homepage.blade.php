@extends('front.front-layout')

@section('title', 'Úvod')

@section('content')


    @include('front.event.components.eventSearchForm',['districts' => $districts, 'allCategories' => $allCategories])
    <section class="recomended-for-u ds">
        <h1 class="title"><span>Vybrali jsme</span> pro vás</h1>

        <div class="slider flx-w arrows">
            @foreach($carouselBanners as $banner)
                @php($event = $banner->event()->first())
                <article>
                    <a href="{{route('detail-event', ['event' => $event])}}" class="article big">
                        <figure>
                            <figcaption>
                                <h2>{{$event->title}}</h2>

                                <div class="tag" style="background: #2d7bf0;">{{$event->category->name}}</div>
                                <p class="date"><img src="{{asset("img/front/date.svg")}}" alt="">{{$event->getFormatedDate()}}</p>

                                <p class="place"><img src="{{asset("img/front/place.svg")}}" alt="">{{$event->place->name}}</p>

                                <div class="dsc">{!! $event->description !!}}</div>
                            </figcaption>
                            <?php
                                if($event->getMainImage()) {
                                    $tempImagePath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
                                        \App\Model\ImageGenerator::CONF_EVENT_HOMEPAGE_CAROUSEL,
                                        $event->id,
                                        $event->getMainImage()
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
    @include('front.spinner')
    <div class="js-content-block-events">
        <section class="interested-actions ds">
            <h2 class="title"><span>Další</span> zajímavé akce</h2>
            <ul class="tabs tab-menu flx">
                <li class="{{$categoryId ? '' : 'active' }} js-category">
                    <a href="{{route('home')}}"
                       class="js-homepage-events-link"
                       data-token="{{csrf_token()}}"
                            >Vše</a>
                </li>
                @foreach($categories as $category)
                    <li class="{{$categoryId == $category->id  ? 'active' : '' }} js-category">
                        <a href="{{route('home',['category' => $category->id])}}"
                           class="js-homepage-events-link"
                           data-token="{{csrf_token()}}"
                           data-category-id="{{$category->id}}"
                        >
                            {{$category->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tabs-content">
                <div class="tab-content open" id="all">
                    <div class="flx-w row" id="js-homepage-events">
                            @include('front.event.components.eventList',['events' => $events])

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
                <div class="center-button"><a class="button" href="{{route('list-event')}}">další akce</a></div>
            </div>
        </section>
    </div>






@endsection