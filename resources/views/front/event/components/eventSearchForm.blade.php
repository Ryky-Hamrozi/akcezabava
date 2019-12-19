<main class="main-section">
    <h1><strong>Objevujte</strong>, co se děje ve vašem regionu</h1>

    <p>Nehledejte složitě na facebooku, vše najdete u nás! Přehledně a na jednom místě.</p>

    <div class="full-search">
        <form action="{{route('list-event')}}" class="flx" id="js-events-filter-form">
            <div class="calcw flx">
                <select name="district_id" id="">
                    <option value="">Všechny okresy</option>
                    @foreach($districts as $district)
                        <option value="{{$district->id}}" @if(isset($selectedDistrict) && $selectedDistrict->id == $district->id) selected @endif>{{$district->name}}</option>
                    @endforeach
                </select>

                <div class="datepicker-box">
                    <input class="datepick" name="date_from" autocomplete="off" type="text" placeholder="Kdykoliv" id="dp1569323369937" value="@if(isset($selectedDate) && $selectedDate){{date('d.m.Y', $selectedDate)}}@endif">
                </div>

                <select name="category_id" id="">
                    <option value="">Všechny druhy akcí</option>
                    @foreach($allCategories as $category)
                        <option value="{{$category->id}}" @if(isset($selectedCategory) && $selectedCategory->id == $category->id) selected @endif>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            {{--<button class="pridat" type="button" name="rozsirene" title="Rozšířené hledání"></button>--}}
            <button class="hledat" type="submit" title="Vyhledat"></button>
        </form>
    </div>
</main>