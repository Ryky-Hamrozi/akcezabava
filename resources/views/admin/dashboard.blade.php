@extends('admin.admin-layout')

@section('title', 'Přehled')

@section('content')
    <div class="w100">
        <h1 class="title">přehled</h1>

        <div class="okresy-kategorie-klicovaslova">
            <div class="container row flx-w">
                <div class="w33p">
                    <div class="flx sb-b">
                        <h2 class="title">Okresy<span>top 5 okresů dle četnosti</span></h2>
                        <a class="all-action" href="{{route('district.index')}}">všechny okresy</a>
                    </div>
                    <div class="bar-chart">
                        <ul>
                            @foreach($topDistricts as $district)
                                <li data-value="{{$district->getEventsCount()}}"><strong>{{$district->name}}</strong><span></span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="w33p">
                    <div class="flx sb-b">
                        <h2 class="title">kategorie<span>top 5 kategorií dle četnosti</span></h2>
                        <a class="all-action" href="{{route('category.index')}}">všechny kategorie</a>
                    </div>
                    <div class="bar-chart">
                        <ul>
                            @foreach($topCategories as $category)
                                <li data-value="{{$category->getEventsCount()}}"><strong>{{$category->name}}</strong><span></span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{--
        <div class="filtration flx-c">
            <div class="styled-select">
                <select name="akce">
                    <option value="">Všechny akce</option>
                    <option value="">Ke schválení </option>
                    <option value="">Ukončené</option>
                    <option value="">Připravované</option>
                </select>
            </div>
            <ul class="date-range flx-c tabs">
                <li><a href="#month">Poslední měsíc</a></li>
                <li><a href="#week">Poslední týden</a></li>
                <li class="active"><a href="#year">Poslední rok</a></li>
            </ul>
            <div class="datepicker-box"><input id="date" type="text" class="hasDatepicker"></div>
        </div>
        <div id="chart_div" style="width: 100%; height: 300px;"><div style="position: relative;"><div dir="ltr" style="position: relative; width: 731px; height: 300px;"><div aria-label="A chart." style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;"><svg width="731" height="300" aria-label="A chart." style="overflow: hidden;"><defs id="_ABSTRACT_RENDERER_ID_0"><clipPath id="_ABSTRACT_RENDERER_ID_1"><rect x="109" y="58" width="514" height="185"></rect></clipPath></defs><rect x="0" y="0" width="731" height="300" stroke="none" stroke-width="0" fill="#ffffff"></rect><g><text text-anchor="start" x="109" y="35.05" font-family="Arial" font-size="13" font-weight="bold" stroke="none" stroke-width="0" fill="#000000">POČET AKCÍ</text><rect x="109" y="24" width="514" height="13" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect></g><g><rect x="109" y="58" width="514" height="185" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g clip-path="url(http://www.testovaci5.leksys.cz.uvds316.active24.cz/akcezabava/administrace/prehled.html#_ABSTRACT_RENDERER_ID_1)"><g><rect x="109" y="242" width="514" height="1" stroke="none" stroke-width="0" fill="#cccccc"></rect><rect x="109" y="211" width="514" height="1" stroke="none" stroke-width="0" fill="#cccccc"></rect><rect x="109" y="181" width="514" height="1" stroke="none" stroke-width="0" fill="#cccccc"></rect><rect x="109" y="150" width="514" height="1" stroke="none" stroke-width="0" fill="#cccccc"></rect><rect x="109" y="119" width="514" height="1" stroke="none" stroke-width="0" fill="#cccccc"></rect><rect x="109" y="89" width="514" height="1" stroke="none" stroke-width="0" fill="#cccccc"></rect><rect x="109" y="58" width="514" height="1" stroke="none" stroke-width="0" fill="#cccccc"></rect></g><g><g><path d="M109.5,242.5L109.5,242.5L156.13636363636363,206.62L202.77272727272725,191.59333333333333L249.4090909090909,210.91333333333333L296.0454545454545,204.78L342.68181818181813,183.31333333333333L389.3181818181818,204.78L435.95454545454544,202.63333333333333L482.59090909090907,186.38L529.2272727272727,180.24666666666667L575.8636363636363,143.44666666666666L622.5,106.64666666666668L622.5,242.5L622.5,242.5Z" stroke="none" stroke-width="0" fill-opacity="0.3" fill="#13c04a"></path></g></g><g><rect x="109" y="242" width="514" height="1" stroke="none" stroke-width="0" fill="#333333"></rect></g><g><path d="M109.5,242.5L156.13636363636363,206.62L202.77272727272725,191.59333333333333L249.4090909090909,210.91333333333333L296.0454545454545,204.78L342.68181818181813,183.31333333333333L389.3181818181818,204.78L435.95454545454544,202.63333333333333L482.59090909090907,186.38L529.2272727272727,180.24666666666667L575.8636363636363,143.44666666666666L622.5,106.64666666666668" stroke="#13c04a" stroke-width="2" fill-opacity="1" fill="none"></path></g></g><g><circle cx="109.5" cy="242.5" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="156.13636363636363" cy="206.62" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="202.77272727272725" cy="191.59333333333333" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="249.4090909090909" cy="210.91333333333333" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="296.0454545454545" cy="204.78" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="342.68181818181813" cy="183.31333333333333" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="389.3181818181818" cy="204.78" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="435.95454545454544" cy="202.63333333333333" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="482.59090909090907" cy="186.38" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="529.2272727272727" cy="180.24666666666667" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="575.8636363636363" cy="143.44666666666666" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle><circle cx="622.5" cy="106.64666666666668" r="6" stroke="none" stroke-width="0" fill="#13c04a"></circle></g><g><g><text text-anchor="middle" x="109.5" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">LED</text></g><g><text text-anchor="middle" x="156.13636363636363" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">ÚN</text></g><g><text text-anchor="middle" x="202.77272727272725" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">BŘE</text></g><g><text text-anchor="middle" x="249.4090909090909" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">DUB</text></g><g><text text-anchor="middle" x="296.0454545454545" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">KVĚ</text></g><g><text text-anchor="middle" x="342.68181818181813" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">ČER</text></g><g><text text-anchor="middle" x="389.3181818181818" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">ČEC</text></g><g><text text-anchor="middle" x="435.95454545454544" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">SRP</text></g><g><text text-anchor="middle" x="482.59090909090907" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">ZÁŘ</text></g><g><text text-anchor="middle" x="529.2272727272727" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">ŘÍJ</text></g><g><text text-anchor="middle" x="575.8636363636363" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">LIS</text></g><g><text text-anchor="middle" x="622.5" y="262.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#222222">PRO</text></g><g><text text-anchor="end" x="96" y="247.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#444444">0</text></g><g><text text-anchor="end" x="96" y="216.38333333333335" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#444444">1,000</text></g><g><text text-anchor="end" x="96" y="185.7166666666667" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#444444">2,000</text></g><g><text text-anchor="end" x="96" y="155.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#444444">3,000</text></g><g><text text-anchor="end" x="96" y="124.38333333333334" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#444444">4,000</text></g><g><text text-anchor="end" x="96" y="93.71666666666668" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#444444">5,000</text></g><g><text text-anchor="end" x="96" y="63.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#444444">6,000</text></g></g></g><g></g></svg><div aria-label="A tabular representation of the data in the chart." style="position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;"><table><thead><tr><th>MĚSÍC</th><th></th></tr></thead><tbody><tr><td>LED</td><td>0</td></tr><tr><td>ÚN</td><td>1,170</td></tr><tr><td>BŘE</td><td>1,660</td></tr><tr><td>DUB</td><td>1,030</td></tr><tr><td>KVĚ</td><td>1,230</td></tr><tr><td>ČER</td><td>1,930</td></tr><tr><td>ČEC</td><td>1,230</td></tr><tr><td>SRP</td><td>1,300</td></tr><tr><td>ZÁŘ</td><td>1,830</td></tr><tr><td>ŘÍJ</td><td>2,030</td></tr><tr><td>LIS</td><td>3,230</td></tr><tr><td>PRO</td><td>4,430</td></tr></tbody></table></div></div></div><div aria-hidden="true" style="display: none; position: absolute; top: 310px; left: 741px; white-space: nowrap; font-family: Arial; font-size: 13px; font-weight: bold;">POČET AKCÍ</div><div></div></div></div>
        --}}
    </div>

    <div class="w35p">
        <div class="flx sb-b">
            <h2 class="title">Všechny<span>akce dle parametru</span></h2>
            <a class="all-action" href="{{route('event.index')}}">všechny akce</a>
        </div>
        <div class="chart-holder">
            <p class="count-action"><strong>11465</strong>akcí celkem</p>
            <div id="donutchart" style="width: 440px; height: 300px;"  data-upcoming="{{$event->getUpcomingEventsCount()}}" data-for-approval="{{$event->getForApprovalEventsCount()}}" data-finished="{{$event->getFinishedEventsCount()}}"></div>
        </div>
        <div class="flx sb-b">
            @php($file = \Illuminate\Support\Facades\DB::table('files_downloads')->where('id', '=', 1)->get()->first())
            <h2 class="title">{{$file->downloads}}<span>Počet stažení pdf souboru - číslo 1</span></h2>
        </div>
        <div class="flx sb-b">
            @php($file = \Illuminate\Support\Facades\DB::table('files_downloads')->where('id', '=', 2)->get()->first())
            <h2 class="title">{{$file->downloads}}<span>Počet stažení pdf souboru - číslo 2</span></h2>
        </div>
        <div class="flx sb-b">
            @php($file = \Illuminate\Support\Facades\DB::table('files_downloads')->where('id', '=', 3)->get()->first())
            <h2 class="title">{{$file->downloads}}<span>Počet stažení pdf souboru - číslo 3</span></h2>
        </div>
        <div class="flx sb-b">
            @php($file = \Illuminate\Support\Facades\DB::table('files_downloads')->where('id', '=', 4)->get()->first())
            <h2 class="title">{{$file->downloads}}<span>Počet stažení pdf souboru - číslo 4</span></h2>
        </div>
        <div class="flx sb-b">
            @php($file = \Illuminate\Support\Facades\DB::table('files_downloads')->where('id', '=', 5)->get()->first())
            <h2 class="title">{{$file->downloads}}<span>Počet stažení pdf souboru - číslo 5</span></h2>
        </div>
    </div>


@endsection

@section('post-footer')

    <script>
        google.charts.load("current", {packages:["corechart"]});
        // area year
        google.charts.setOnLoadCallback(areaChart);

        function areaChart() {
            var l = 0;
            var u = 7820;
            var b = 1660;
            var d = 1030;
            var k = 1230;
            var c = 1930;
            var cc = 1230;
            var s = 1300;
            var z = 1830;
            var r = 2030;
            var ld = 3230;
            var p = 4430;

            var data = google.visualization.arrayToDataTable([
                ['MĚSÍC', ''],
                ['LED',  l],
                ['ÚN',  u],
                ['BŘE',  b],
                ['DUB',  d],
                ['KVĚ',  k],
                ['ČER',  c],
                ['ČEC',  cc],
                ['SRP',  s],
                ['ZÁŘ',  z],
                ['ŘÍJ',  r],
                ['LIS',  ld],
                ['PRO',  p],
            ]);
            var options = {
                title: 'POČET AKCÍ',
                /*vAxis: {minValue: 0, ticks: [0, 1000, 2000, 3000, 4000, 5000, 6000]},*/
                tooltip: { isHtml: true },
                legend: {
                    position: 'none'
                },
                pointSize: 10,
                series: {
                    0: { pointShape: 'circle', color: '#13c04a' }
                }
            };
            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);

            google.visualization.events.addListener(chart, 'onmouseover', selectHandler);
            function selectHandler(e) {
                var div = document.createElement('div');
                div.className = 'rozdil';
                div.innerHTML = '+15%';
                $(".google-visualization-tooltip").append(div);
            }
        }

        $(document).ready(function(){
            //On button click, load new data
            $(".date-range li a").click(function(e){

                var bob = jQuery(this).attr("href");

                if (bob == "#week") {
                    var po = 0;
                    var ut = 1170;
                    var st = 1660;
                    var ct = 1030;
                    var pa = 1230;
                    var so = 1930;
                    var ne = 1230;

                    var data = google.visualization.arrayToDataTable([
                        ['Týden', ''],
                        ['PO',  po],
                        ['ÚT',  ut],
                        ['ST',  st],
                        ['ČT',  ct],
                        ['PÁ',  pa],
                        ['SO',  so],
                        ['NE',  ne],
                    ]);

                    var options = {
                        title: 'POČET AKCÍ',
                        vAxis: {minValue: 0, ticks: [0, 1000, 2000, 3000]},
                        tooltip: { isHtml: true },
                        legend: {
                            position: 'none'
                        },
                        pointSize: 10,
                        series: {
                            0: { pointShape: 'circle', color: '#13c04a' }
                        }
                    };
                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                    chart.draw(data, options);

                    google.visualization.events.addListener(chart, 'onmouseover', selectHandler);
                    function selectHandler(e) {
                        var div = document.createElement('div');
                        div.className = 'rozdil';
                        div.innerHTML = '+15%';
                        $(".google-visualization-tooltip").append(div);
                    }
                }
                if (bob == "#month") {
                    var data = google.visualization.arrayToDataTable([
                        ['Den', ''],
                        ['1',  190],
                        ['2',  360],
                        ['3',  410],
                        ['4',  120],
                        ['5',  80],
                        ['6',  157],
                        ['7',  211],
                        ['8',  190],
                        ['9',  360],
                        ['10',  410],
                        ['11',  120],
                        ['12',  80],
                        ['13',  157],
                        ['14',  211],
                    ]);

                    var options = {
                        title: 'POČET AKCÍ',
                        vAxis: {minValue: 0, ticks: [0, 50, 100, 150, 200, 250, 300, 350, 400]},
                        tooltip: { isHtml: true },
                        legend: {
                            position: 'none'
                        },
                        pointSize: 10,
                        series: {
                            0: { pointShape: 'circle', color: '#13c04a' }
                        }
                    };
                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                    chart.draw(data, options);

                    google.visualization.events.addListener(chart, 'onmouseover', selectHandler);
                    function selectHandler(e) {
                        var div = document.createElement('div');
                        div.className = 'rozdil';
                        div.innerHTML = '+15%';
                        $(".google-visualization-tooltip").append(div);
                    }
                }
                if (bob == "#year") {
                    var l = 0;
                    var u = 1170;
                    var b = 1660;
                    var d = 1030;
                    var k = 1230;
                    var c = 1930;
                    var cc = 1230;
                    var s = 1300;
                    var z = 1830;
                    var r = 2030;
                    var ld = 3230;
                    var p = 4430;

                    var data = google.visualization.arrayToDataTable([
                        ['MĚSÍC', ''],
                        ['LED',  l],
                        ['ÚN',  u],
                        ['BŘE',  b],
                        ['DUB',  d],
                        ['KVĚ',  k],
                        ['ČER',  c],
                        ['ČEC',  cc],
                        ['SRP',  s],
                        ['ZÁŘ',  z],
                        ['ŘÍJ',  r],
                        ['LIS',  ld],
                        ['PRO',  p],
                    ]);
                    var options = {
                        title: 'POČET AKCÍ',
                        vAxis: {minValue: 0, ticks: [0, 1000, 2000, 3000, 4000, 5000, 6000]},
                        tooltip: { isHtml: true },
                        legend: {
                            position: 'none'
                        },
                        pointSize: 10,
                        series: {
                            0: { pointShape: 'circle', color: '#13c04a' }
                        }
                    };
                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                    chart.draw(data, options);

                    google.visualization.events.addListener(chart, 'onmouseover', selectHandler);
                    function selectHandler(e) {
                        var div = document.createElement('div');
                        div.className = 'rozdil';
                        div.innerHTML = '+15%';
                        $(".google-visualization-tooltip").append(div);
                    }
                }
            });
        });

    </script>

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

    <script>
        $(document).ready(function() {
            // Produces width of .barChart (%)
            $('.bar-chart').each(function() {
                var tab_attribs = $(this).find('li').map(function () {
                    return $(this).attr("data-value");
                });
                $(this).find('li').each(function() {
                    var biggest = Math.max.apply( null, tab_attribs );
                    var dataWidth = $(this).data('value');
                    var pixels = 100;
                    var percentage = (dataWidth * pixels) / biggest;
                    $(this).append('<em>&nbsp;</em>');
                    $(this).find('span').append('<span>' + dataWidth + '</span>');
                    $(this).find('em').width(percentage+'%');
                });
            });
        });
    </script>

@endsection
