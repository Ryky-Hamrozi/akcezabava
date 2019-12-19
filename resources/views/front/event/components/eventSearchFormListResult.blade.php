<section class="all-films ds">
    <h2 class="filter-info">
        Nalezeno <strong>{{$events->count()}}</strong>
        @if(isset($selectedCategory)){{$selectedCategory->name}}@else Akcí @endif
        @if(isset($selectedDistrict)) v regionu <strong>{{$selectedDistrict->name}}</strong>@endif
        @if(isset($selectedDate) && $selectedDate) termínu <strong>{{date('d.m.Y', $selectedDate)}}</strong>@endif.
    </h2>
    <div class="flx-w row">
        @include('front.event.components.eventList',['events' => $events])
    </div>
    <div class="strankovani">
        <ul class="pagination">
            <li class="active"><a href="" data-jzz-gui-player="true">16</a></li>
            <li><a href="" data-jzz-gui-player="true">32</a></li>
            <li><a href="" data-jzz-gui-player="true">48</a></li>
            <li><a href="" data-jzz-gui-player="true">64</a></li>
        </ul>
        <a class="button" title="načíst další akce" href="{{route('list-event')}}" data-jzz-gui-player="true">načíst další akce</a>
    </div>
</section>