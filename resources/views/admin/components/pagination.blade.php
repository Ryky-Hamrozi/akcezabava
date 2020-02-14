<div class="strankovani flx sb-c">
    <p>Zobrazeno <strong>{{$items->count()}}</strong> ze <strong>{{$items->total()}}</strong></p>
    {{$items->appends(request()->except('page'))->render()}}
</div>
