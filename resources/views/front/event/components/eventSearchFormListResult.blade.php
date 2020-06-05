<section class="all-films ds">
    <h2 class="filter-info">
        Nalezeno <strong>{{$totalEvents}}</strong> akcí
        @if(isset($request) && $request->input('title')) podle hledaneho výrazu <strong>{{ $request->input('title') }}</strong> @endif
        @if(isset($selectedCategory)) v kategorii <strong>{{$selectedCategory->name}}</strong> @endif
        @if(isset($selectedDistrict)) v regionu <strong>{{$selectedDistrict->name}}</strong>@endif
        @if(isset($selectedDate) && $selectedDate) v termínu od <strong>{{date('d.m.Y', $selectedDate)}}</strong>@endif.
    </h2>
    <div class="flx-w row">
        @include('front.event.components.eventList',['events' => $events])
    </div>

    @include('front.event.components.pagination',['items'=> $events])

</section>
