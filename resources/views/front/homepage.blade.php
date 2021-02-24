@extends('front.front-layout')

@section('title', 'Úvod')

@section('content')


    @include('front.event.components.eventSearchForm',['districts' => $districts, 'allCategories' => $allCategories])
    @if(count($carouselBanners))
    <section class="recomended-for-u ds">
        <h1 class="title"><span>Vybrali jsme</span> pro vás</h1>

        <div class="slider flx-w arrows">
            @foreach($carouselBanners as $banner)
                @php($event = $banner->event()->first())
                @if($event)
                    <article>
                        {{--<a href="@if(!$banner->url){{route('detail-event', ['event' => $event])}}@else{{$banner->url}}@endif" @if($banner->url)target="_blank"@endif class="article big">--}}
                        <a href="{{route('detail-event', ['event' => $event])}}"  class="article big">
                            <figure>
                                <figcaption>
                                    <h2>{{$event->title}}</h2>

                                    <div class="tag" style="background: #2d7bf0;">{{$event->category->name}}</div>
                                    <p class="date"><img src="{{asset("img/front/date.svg")}}" alt="">{{$event->getFormatedDate()}}</p>

                                    <p class="place"><img src="{{asset("img/front/place.svg")}}" alt="">{{$event->place->name}}</p>

                                    <div class="dsc">{{strip_tags($event->description)}}</div>
                                </figcaption>
                                @if($event->getMainImage())
                                    <?php
                                        $tempImagePath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
                                            \App\Model\ImageGenerator::CONF_EVENT_HOMEPAGE_CAROUSEL,
                                            $event->id,
                                            $event->getMainImage()
                                        );
                                    ?>
                                    <div class="box" style="background-image:url({{asset($tempImagePath)}})"></div>
                                @endif
                            </figure>
                        </a>
                    </article>
                    @else
                    <article>
                        <a @if($banner->url)href="{{$banner->url}}"@endif  class="article big">
                            <figure>
                                <?php
                                $tempImagePath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
                                    \App\Model\ImageGenerator::CONF_EVENT_HOMEPAGE_CAROUSEL,
                                    $banner->id,
                                    $banner->getImagePath()
                                );
                                ?>
                                    <div class="box-img" style="background-image:url({{asset($tempImagePath)}})"></div>
                            </figure>
                        </a>
                    </article>
                @endif
            @endforeach

        </div>

    </section>
    @endif
    @include('front.spinner', ['class' => 'abs'])
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
                    </div>
                </div>
                <div class="center-button"><a class="button" href="{{route('list-event')}}">další akce</a></div>
            </div>
        </section>
    </div>






@endsection
