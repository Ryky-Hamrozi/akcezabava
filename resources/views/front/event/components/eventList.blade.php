@foreach($events as $event)
    @include('front.event.components.eventThumbnail',['event' => $event])
@endforeach
@include('front.event.banners',['actionBanner' => $actionBanner])
