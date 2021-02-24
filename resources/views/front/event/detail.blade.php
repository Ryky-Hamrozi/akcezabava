@extends('front.front-layout')

@section('title', $event->title)

@section('content')

    <ul class="breadcrumb">
        <li><a href="{{route('home')}}">Úvod</a></li>
        <li><a href="{{route('list-event')}}">akce</a></li>
        <li><a href="">{{$event->title}}</a></li>
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
                                href="{{$event->getFacebookUrl()}}" target="_blank">{{$event->fb_url}}</a></li>
                @endif
            </ul>
        </div>
        <div class="left-side @if(!$eventBanner) fullsize @endif">
            {{--<a class="button share" title="" href="">Sdílet událost <span><img src="{{asset('img/front/share.svg')}}" alt="Share"></span></a>--}}
            <div class="description">
                {!!$event->description!!}
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
                <a @if($eventBanner->url)href="{{$eventBanner->url}}"@endif class="reklama"><img src="{{$tempBannerDetail}}" alt="reklama"></a>
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
