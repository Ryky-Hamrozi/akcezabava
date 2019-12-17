<div class="modal-handler" id="new-action-modal">
    <div class="modal-content">
        <div class="modal-header flx sb-c">
            <h5>
                @if(isset($item))
                    UPRAVIT OKRES
                @else
                    NOVÝ OKRES
                @endif
            </h5>
            <button class="close" title="Zavřít" type="button"></button>
        </div>
        <div class="modal-body">
            <form action="{{ isset($item) ?route('district.update',['id' => $item->id]) : route('district.store')}}" method="post">
                @csrf
                @if(isset($item))
                    @method('put')
                @endif
                <div class="inputs flx-w row">
                    <div class="box-input w100">
                        <div class="box-input w100">
                            <label for="name">Název</label>
                            <input id="name" name="name" type="text" value="{{$item->name ?? ''}}">
                        </div>
                    </div>
                </div>
                <div class="center-button">
                    <button class="button" type="submit" name="button">ULOŽIT</button>
                </div>
            </form>
        </div>
    </div>
</div>