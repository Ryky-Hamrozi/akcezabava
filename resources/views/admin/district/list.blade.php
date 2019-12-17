@extends('admin.admin-layout')

@section('title', 'Okresy')

@section('content')
    <div class="flx sb-c mt30">
        <h1 class="title">top 5 okresů <span>s nejvíce akcemi</span></h1>
        <button class="button add addAction" type="button" data-token="{{csrf_token()}}" data-model={{App\Model\District::class}}><span class="plus"><img src="{{asset('img/admin/plus.svg')}}" alt="plus"></span>Nový okres</button>
    </div>
    <div class="flx-w row">
        <div class="w60p">
            <div class="bar-chart">
                <ul>
                    @foreach($topDistricts as $district)
                        <li data-value="{{$district->getEventsCount()}}"><strong>{{$district->name}}</strong><span></span></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="w40p">
            <div class="styled-select with-label">
                <label for="vokrese">V okrese: </label>
                <select id="vokrese" name="vokrese" class="pie-chart-select" data-model="{{App\Model\District::class}}" data-token="{{csrf_token()}}" data-url="{{route('changePieChart')}}">
                    @foreach($topDistricts as $district)
                        <option value="{{$district->id}}">{{$district->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="chart-holder">
                <p class="count-action"><strong></strong> akcí v kategorii</p>
                <div id="donutchart" style="width: 440px; height: 300px;" data-upcoming="{{$topDistricts->first()->getUpcomingEventsCount()}}" data-for-approval="{{$topDistricts->first()->getForApprovalEventsCount()}}" data-finished="{{$topDistricts->first()->getFinishedEventsCount()}}"></div>
            </div>
        </div>
    </div>
    <h2 class="title">všechny<span>aktivní okresy</span></h2>
    <form method="POST" action="{{route('groupAction')}}">
        @csrf
        <input type="hidden" name="model" value="{{App\Model\District::class}}">
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
                <th>OKRES</th>
                <th>POČET AKCÍ</th>
                <th>AKCE</th>
            </tr>
            </thead>
            <tbody>
            @forelse($districts as $district)
            <tr class="row-{{$district->id}}">
                <td data-name="Označit"><input name="ids" type="checkbox" value="{{$district->id}}"></td>
                <td data-name="Okres">{{$district->name}}</td>
                <td data-name="Místo">{{$district->getEventsCount()}}</td>
                <td data-name="Akce" class="action">
                    <button class="ac-btn get-modal-content" title="Náhled" data-tooltip="náhled" data-token="{{csrf_token()}}" data-id="{{$district->id}}"  data-model="{{get_class($district)}}"  name="nahled" type="button"><img src="{{asset('img/admin/detail.svg')}}" alt="Náhled"></button>
                    <button class="ac-btn" title="Smazat" data-tooltip="smazat" data-item-name="okres" data-token="{{csrf_token()}}" data-id="{{$district->id}}"  data-model="{{get_class($district)}}" name="smazat" type="button"><img src="{{asset('img/admin/remove.svg')}}" alt="Smazat"></button>
                </td>
            </tr>
            @empty

            @endforelse
            </tbody>
        </table>
    </form>
    {{-- strankovani --}}
    @include('admin.components.pagination',['items'=> $districts])
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

    @include('admin.district.addModal')
    @include('admin.components.removeModal')

@endsection