<article class="p15 w33p">
    <a href="{{route('detail-event',['id' => $event->id])}}" class="article">
        <figure>
            <?php
            $tempImagePath = "";
            if ($event->getMainImage()) {
                $tempImagePath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
                        \App\Model\ImageGenerator::CONF_EVENT_HOMEPAGE_LIST,
                        $event->id,
                        $event->getMainImage()
                );

            }
            ?>
            <div class="box" style='background-image:url("{{asset($tempImagePath)}}")'></div>
            <figcaption>
                <div class="tag"
                     style="background: {{$event->category->backColor}}; color: {{$event->category->foreColor}}">{{$event->category->name}}</div>
                <h2>{{$event->title}}</h2>

                <p class="date"><img src="{{asset('img/front/date.svg')}}" alt="">{{$event->getFormatedDate()}}</p>

                <p class="place"><img src="{{asset('img/front/place.svg')}}" alt="">{{$event->place->name}}</p>
            </figcaption>
        </figure>
    </a>
</article>
