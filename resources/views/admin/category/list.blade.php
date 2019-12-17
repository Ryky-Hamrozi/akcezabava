@extends('admin.admin-layout')

@section('title', 'Kategorie')

@section('content')
    <div class="flx sb-c mt30 devpow">
        <h1 class="title">počet akcí <span>ve všech kategoriích</span></h1>
        <button class="button add addAction" type="button" data-token="{{csrf_token()}}" data-model={{App\Model\Category::class}}><span class="plus"><img src="{{asset('img/admin/plus.svg')}}" alt="plus"></span>NOVÁ KATEGORIE</button>
    </div>
    <div class="flx-w row">
        <div class="w60p">
            <div class="bar-chart">
                @foreach($orderedCategories as $category)
                    <li data-value="{{$category->events_count}}"><strong>{{$category->name}}</strong><span></span><em>&nbsp;</em></li>
               @endforeach
            </div>
        </div>
        <div class="w40p">
            <div class="styled-select with-label">
                <label for="vkategorii">V kategorii: </label>
                <select id="vkategorii" name="vkategorii" class="pie-chart-select" data-model="{{App\Model\Category::class}}" data-token="{{csrf_token()}}" data-url="{{route('changePieChart')}}">
                    @foreach($orderedCategories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="chart-holder">
                <p class="count-action"><strong></strong>akcí v kategorii</p>
                <div id="donutchart" style="width: 440px; height: 300px;" data-upcoming="{{$orderedCategories->first()->getUpcomingEventsCount()}}" data-for-approval="{{$orderedCategories->first()->getForApprovalEventsCount()}}" data-finished="{{$orderedCategories->first()->getFinishedEventsCount()}}"></div>
            </div>
        </div>
    </div>

    <h2 class="title">všechny<span>aktivní kategorie</span></h2>
    <form method="POST" action="{{route('groupAction')}}">
        @csrf
        <input type="hidden" name="model" value="{{App\Model\Category::class}}">
        <div class="filtration">
            <div class="styled-select with-label">
                <label for="oznacene">Označené: </label>
                <select id="oznacene" name="action">
                    <option value="delete">Smazat</option>
                </select>
                <button class="button ml-10">Potvrdit</button>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th><input name="" type="checkbox"></th>
                <th>KATEGORIE</th>
                <th>POČET AKCÍ</th>
                <th>AKCE</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr class="row-{{$category->id}}">
                    <td data-name="Označit"><input name="ids[]" type="checkbox" value="{{$category->id}}"></td>
                    <td data-name="Okres">{{$category->name}}</td>
                    <td data-name="Místo">{{$category->getEventsCount()}}</td>
                    <td data-name="Akce" class="action">
                        <button class="ac-btn get-modal-content" title="Náhled" data-tooltip="náhled" data-token="{{csrf_token()}}" data-id="{{$category->id}}"  data-model="{{get_class($category)}}"  name="nahled" type="button"><img src="{{asset('img/admin/detail.svg')}}" alt="Náhled"></button>
                        <button class="ac-btn" title="Smazat" data-tooltip="smazat" data-item-name="kategorii" data-token="{{csrf_token()}}" data-id="{{$category->id}}"  data-model="{{get_class($category)}}" name="smazat" type="button"><img src="{{asset('img/admin/remove.svg')}}" alt="Smazat"></button>
                    </td>
                </tr>
            @empty

            @endforelse
            </tbody>
        </table>
    </form>
    {{--
    <h2 class="title">historie<span>posledních přidaných akcí</span></h2>
    <div class="filtration">
        <div class="styled-select with-label">
            <label for="oznacene">Označené: </label>
            <select id="oznacene" name="akce">
                <option value="">Smazat</option>
                <option value="">Lorem</option>
                <option value="">Ipsum</option>
            </select>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th><input name="" type="checkbox"></th>
            <th>PŘIDÁNO</th>
            <th>NÁZEV</th>
            <th>OKRES</th>
            <th>MÍSTO</th>
            <th>TERMÍN</th>
            <th>POŘADATEL</th>
            <th>FOTO</th>
            <th>AKCE</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td data-name="Označit"><input name="" type="checkbox"></td>
            <td data-name="Přidáno"><div>16.9.2017 </div>12:34</td>
            <td data-name="Název">Barbora Mochowa: Hranice - Dny evropského dědictví</td>
            <td data-name="Okres">Hranice</td>
            <td data-name="Místo">Synagoga Hranice</td>
            <td data-name="Termín"><div>16.9.2017</div> 17:00 - 19:00</td>
            <td data-name="Pořadatel">obec Hranice</td>
            <td data-name="Foto">ANO (5)</td>
            <td data-name="Akce" class="action">
                <button class="ac-btn" title="Náhled" data-tooltip="náhled" name="nahled" type="button"><img src="img/detail.svg" alt="Náhled"></button>
                <button class="ac-btn" title="Smazat" data-tooltip="smazat" name="smazat" type="button"><img src="img/remove.svg" alt="Smazat"></button>
            </td>
        </tr>
        <tr>
            <td data-name="Označit"><input name="" type="checkbox"></td>
            <td data-name="Přidáno"><div>16.9.2017 </div>12:34</td>
            <td data-name="Název">Barbora Mochowa: Hranice - Dny evropského dědictví</td>
            <td data-name="Okres">Hranice</td>
            <td data-name="Místo">Synagoga Hranice</td>
            <td data-name="Termín"><div>16.9.2017</div> 17:00 - 19:00</td>
            <td data-name="Pořadatel">obec Hranice</td>
            <td data-name="Foto">ANO (5)</td>
            <td data-name="Akce" class="action">
                <button class="ac-btn" title="Náhled" data-tooltip="náhled" name="nahled" type="button"><img src="img/detail.svg" alt="Náhled"></button>
                <button class="ac-btn" title="Smazat" data-tooltip="smazat" name="smazat" type="button"><img src="img/remove.svg" alt="Smazat"></button>
            </td>
        </tr>
        <tr>
            <td data-name="Označit"><input name="" type="checkbox"></td>
            <td data-name="Přidáno"><div>16.9.2017 </div>12:34</td>
            <td data-name="Název">Barbora Mochowa: Hranice - Dny evropského dědictví</td>
            <td data-name="Okres">Hranice</td>
            <td data-name="Místo">Synagoga Hranice</td>
            <td data-name="Termín"><div>16.9.2017</div> 17:00 - 19:00</td>
            <td data-name="Pořadatel">obec Hranice</td>
            <td data-name="Foto">ANO (5)</td>
            <td data-name="Akce" class="action">
                <button class="ac-btn" title="Náhled" data-tooltip="náhled" name="nahled" type="button"><img src="img/detail.svg" alt="Náhled"></button>
                <button class="ac-btn" title="Smazat" data-tooltip="smazat" name="smazat" type="button"><img src="img/remove.svg" alt="Smazat"></button>
            </td>
        </tr>
        </tbody>
    </table>
    --}}

    {{-- strankovani --}}
    @include('admin.components.pagination',['items'=> $categories])

@endsection

@section('post-footer')

    <script>
        google.charts.load("current", {packages:["corechart"]});
        // kolac
        google.charts.setOnLoadCallback(peiChart);


        function peiChart() {

            // pocty akci
            var pripravovane = parseInt($('#donutchart').attr('data-upcoming'));
            var keSchvaleni = parseInt($('#donutchart').attr('data-for-approval'));
            var ukoncene = parseInt($('#donutchart').attr('data-finished'));
            var count = pripravovane + keSchvaleni + ukoncene;
            $(".count-action strong").text(count);

            var data = google.visualization.arrayToDataTable([
                ['Akce', 'Počet akcí'],
                ['Připravované', pripravovane,],
                ['Ke schválení', keSchvaleni],
                ['Ukončené', ukoncene],
            ]);
            var options = {
                pieHole: 0.85,
                pieSliceText: 'none',
                slices: {
                    0: { color: '#13c04a' },
                    1: { color: '#f9a513' },
                    2: { color: '#d71921' }
                },
                tooltip: { isHtml: true },
                legend: {
                    position: 'bottom'
                },
            };
            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }

    </script>

    <!-- OKRESY KATEGORIE KLICOVA SLOVA -->
    <script>
        $(document).ready(function() {
            // vzit hodnoty, zjistit nejvetsi a dle ni radit
            $('.bar-chart li').each(function() {
                var tab_attribs = $('.bar-chart li').map(function () {
                    return $(this).attr("data-value");
                });
                var biggest = Math.max.apply( null, tab_attribs );
                var dataWidth = $(this).data('value');
                var pixels = 100;
                var percentage = (dataWidth * pixels) / biggest;
                $(this).append('<em>&nbsp;</em>');
                $(this).find('span').append('<span>' + dataWidth + '</span>');
                $(this).find('em').width(percentage+'%');
            });
        });
        // razeni od nejvetsiho
        var items = $('.bar-chart li').get();
        items.sort(function(a, b) {
            var valueA = parseInt($(a).attr("data-value"));
            var valueB = parseInt($(b).attr("data-value"));
            if (valueA < valueB) return 1;
            if (valueA > valueB) return -1;
            return 0;
        });
        $(".bar-chart").empty().append(items);
    </script>


    @include('admin.category.addModal')
    @include('admin.components.removeModal')
@endsection