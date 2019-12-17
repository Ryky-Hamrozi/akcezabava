<article class="p15 w33p">
        <a href="{{route('detail-event',['id' => $event->id])}}" class="article">
            <figure>
                <div class="box" style='background-image:url("{{asset($event->getMainImage())}}")'></div>
                <figcaption>
                <div class="tag" style="background: {{$event->category->backColor}}; color: {{$event->category->foreColor}}">{{$event->category->name}}</div>
                <h2>{{$event->title}}</h2>
                <p class="date"><img src="{{asset('img/front/date.svg')}}" alt="">{{$event->getFormatedDate()}}</p>
                <p class="place"><img src="{{asset('img/front/place.svg')}}" alt="">{{$event->place->name}}</p>
                </figcaption>
            </figure>
            </a>
        </article>