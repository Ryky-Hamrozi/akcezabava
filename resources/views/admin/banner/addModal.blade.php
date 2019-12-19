<div class="modal-handler" id="new-action-modal">
    <div class="modal-content">
        <div class="modal-header flx sb-c">
            <h5>
                @if(isset($item))
                    EDITACE BANERU
                @else
                    NOVÝ BANER
                @endif
            </h5><button class="close" title="Zavřít" type="button"></button>
        </div>
        <div class="modal-body">
            <form action="{{isset($item) ? route('banner.update',['id' => $item->id]) : route('banner.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($item))
                    @method('put')
                @endif
                <div class="inputs flx-w row">
                    <div class="box-input w50">
                        <label for="name">Název</label>
                        <input id="name" name="name" type="text"  value="{{$item->name ?? ''}}">
                    </div>
                    <div class="box-input w50">
                        <label for="location">Umístění</label>
                        <select id="location" name="location">
                            @foreach(App\Model\Banner::locations as $index => $location)
                                <option value="{{$index}}" {{isset($item) && $item->location == $index ? "selected" : ''}}>{{$location}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="inputs flx-w row">
                    <div class="box-input w50">
                        <label for="event">Akce</label>
                        <select id="event" name="event">
                            <option value="0" {{isset($item) && !isset($item->event) ? "selected" : ''}}>Nenastaveno</option>
                            @foreach(App\Model\Event::all() as $event)
                                <option value="{{$event->id}}" {{isset($item->event) && $item->event->id == $event->id ? "selected" : ''}}>{{$event->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="box-input w50">
                        <label for="url">Url</label>
                        <input id="url" name="url" type="text"  value="{{$item->url ?? ''}}">
                    </div>
                </div>

                <div class="inputs flx-w row">
                    <div class="box-input w100">
                        <label for="image">Obrázek</label>
                        <input type="file" accept="image/png, image/jpeg" name="image">
                    </div>
                </div>

                <div class="center-button">
                    <button class="button" type="submit" name="button">ULOŽIT</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

    });
</script>