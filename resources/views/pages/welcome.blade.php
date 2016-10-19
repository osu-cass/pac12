@extends('template')

@section('title', 'PAC-12 Challenge')

@section('css')
{{ HTML::style('assets/jqplot/jquery.jqplot.min.css') }}
{{ HTML::style('assets/css/pages/welcome.css') }}
@stop

@section('js')
{{ HTML::script('assets/jqplot/jquery.jqplot.min.js') }}
{{ HTML::script('assets/jqplot/plugins/jqplot.barRenderer.min.js') }}
{{ HTML::script('assets/jqplot/plugins/jqplot.categoryAxisRenderer.min.js') }}
{{ HTML::script('assets/jqplot/plugins/jqplot.pieRenderer.min.js') }}
{{ HTML::script('assets/jqplot/plugins/jqplot.pointLabels.min.js') }}
<script>
    $(document).ready(function() {
            $.jqplot.config.enablePlugins = true;
            var options = {
                // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
                animate: !$.jqplot.use_excanvas,
                seriesDefaults:{
                    renderer:$.jqplot.BarRenderer,
                    pointLabels: { show: true }
                },
                axesDefaults: {
                    tickOptions: {
                        showGridline: false
                    }
                },
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: []
                    },
                    yaxis: {
                        showTicks: false,
                        rendererOptions: {
                            drawBaseline: false
                        }
                    }
                },
                highlighter: {
                    show: false
                },
                grid: {
                    background: 'rgba(0, 0, 0, 0)',
                    borderWidth: 0
                }
            };

            var plot0Options = options;
            plot0Options.axes.xaxis.ticks = ['','','','','','','','','','','',''];
            var plot0Data = [
                {{ $totals[0]->minutes }},
        {{ $totals[1]->minutes }},
    {{ $totals[2]->minutes }},
    {{ $totals[3]->minutes }},
    {{ $totals[4]->minutes }},
    {{ $totals[5]->minutes }},
    {{ $totals[6]->minutes }},
    {{ $totals[7]->minutes }},
    {{ $totals[8]->minutes }},
    {{ $totals[9]->minutes }},
    {{ $totals[10]->minutes }},
    {{ $totals[11]->minutes }}
    ];
    var plot0 = $.jqplot('chart', [plot0Data], options);

    @if(Carbon::now()->toDateString() == '2014-02-27' || Input::get('graphs'))
    var plot1Options = options;
    plot1Options.axes.xaxis.ticks = ['',''];
    var plot1Data = [
        {{ $totals[1]->minutes }},
    {{ $totals[0]->minutes }}
    ];
    var plot1 = $.jqplot('chart1', [plot1Data], plot1Options);

    var plot2Data = [
        {{ $totals[3]->minutes }},
    {{ $totals[4]->minutes }}
    ];
    var plot2 = $.jqplot('chart2', [plot2Data], plot1Options);

    var plot3Data = [
        {{ $totals[8]->minutes }},
    {{ $totals[9]->minutes }}
    ];
    var plot3 = $.jqplot('chart3', [plot3Data], plot1Options);

    var plot4Data = [
        {{ $totals[6]->minutes }},
    {{ $totals[7]->minutes }}
    ];
    var plot4 = $.jqplot('chart4', [plot4Data], plot1Options);

    var plot5Data = [
        {{ $totals[5]->minutes }},
    {{ $totals[2]->minutes }}
    ];
    var plot5 = $.jqplot('chart5', [plot5Data], plot1Options);

    var plot6Data = [
        {{ $totals[11]->minutes }},
    {{ $totals[10]->minutes }}
    ];
    var plot6 = $.jqplot('chart6', [plot6Data], plot1Options);
    @endif
    });
</script>
@stop

@section('header')
    @include('header')
@stop

@section('content')
<div class="section chart<?php
if (time() < strtotime('2014-02-24') && !Input::get('graphs')) {
    echo ' cripple';
}
?>">
    <h1 class="text-center">STUDENTS REGISTERED</h1>
    <div id="chart">
    </div>
    <div id="studentsTotals">
        <div>{{ $totals[0]->students }}</div>
        <div>{{ $totals[1]->students }}</div>
        <div>{{ $totals[2]->students }}</div>
        <div>{{ $totals[3]->students }}</div>
        <div>{{ $totals[4]->students }}</div>
        <div>{{ $totals[5]->students }}</div>
        <div>{{ $totals[6]->students }}</div>
        <div>{{ $totals[7]->students }}</div>
        <div>{{ $totals[8]->students }}</div>
        <div>{{ $totals[9]->students }}</div>
        <div>{{ $totals[10]->students }}</div>
        <div>{{ $totals[11]->students }}</div>
    </div>
    <div id="chartLabels">
        <img src="{{ URL::to('assets/images/graph-labels.png') }}" />
    </div>
</div>
<div id="header-sub">
    @include('alerts')
    <h1>PAC-12 CHALLENGE</h1>
    <div class="text">
        {!! $page->html !!}
        <p>
            <a href="{{ URL::to('account') }}" class="btn btn-primary">Register/Sign-in</a>
        </p>
    </div>
</div>
@if($challenge)
    <div class="section centered challenge">
        <img src="{{ asset('assets/images/section-3.png') }}" alt="" class="section-divider">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="area">
                    <h1>{{ $challenge->name }}</h1>
                    <h4>{{ date('M d, Y' ,strtotime($challenge->published_start)) . ' - ' . date('M d, Y', strtotime($challenge->published_end))}}</h4>
                    <p>{{ $challenge->description }}</p>
                </div>
            </div>
        </div>
    </div>
@endif
@if(Carbon::now()->toDateString() == '2014-02-27' || Input::get('graphs'))
<div class="section chart2">
    <div class="row">
        <div class="col-xs-2">
            <div class="pad">
                <div id="chart1" class="duelChart">
                </div>
                <div class="text-center">
                    <div class="miniIcon icon2"></div>
                    <div class="miniIcon icon1"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="pad">
                <div id="chart2" class="duelChart">
                </div>
                <div class="text-center">
                    <div class="miniIcon icon4"></div>
                    <div class="miniIcon icon5"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="pad">
                <div id="chart3" class="duelChart">
                </div>
                <div class="text-center">
                    <div class="miniIcon icon9"></div>
                    <div class="miniIcon icon10"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="pad">
                <div id="chart4" class="duelChart">
                </div>
                <div class="text-center">
                    <div class="miniIcon icon7"></div>
                    <div class="miniIcon icon8"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="pad">
                <div id="chart5" class="duelChart">
                </div>
                <div class="text-center">
                    <div class="miniIcon icon6"></div>
                    <div class="miniIcon icon3"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="pad">
                <div id="chart6" class="duelChart">
                </div>
                <div class="text-center">
                    <div class="miniIcon icon12"></div>
                    <div class="miniIcon icon11"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="section s3">
    <img src="{{ asset('assets/images/section-3.png') }}" alt="" class="section-divider">
    {!! $page->get_module_by_number(1) !!}
    <div class="icons">
        @foreach($schools as $school)
            <a class="icon icon{{ $school->id }}" href="{{ $school->url }}" target="_blank"></a>
        @endforeach
        {{--<a class="icon icon1" href="http://rec.arizona.edu/" target="_blank"></a>--}}
        {{--<a class="icon icon2" href="https://fitness.asu.edu/" target="_blank"></a>--}}
        {{--<a class="icon icon3" href="http://recsports.berkeley.edu/about/events/fitwellweek/" target="_blank"></a>--}}
        {{--<a class="icon icon4" href="http://uoregon.edu/sports" target="_blank"></a>--}}
        {{--<a class="icon icon5" href="http://calendar.oregonstate.edu/" target="_blank"></a>--}}
        {{--<a class="icon icon6" href="http://www.stanford.edu/dept/pe/cgi-bin/cardinalrec/pac-12-fitness-challenge/" target="_blank"></a>--}}
        {{--<a class="icon icon7" href="http://www.recreation.ucla.edu/pac12challenge" target="_blank"></a>--}}
        {{--<a class="icon icon8" href="http://sait.usc.edu/Recsports/calendars/sports/pac-12-fitness-challenge-week-2014" target="_blank"></a>--}}
        {{--<a class="icon icon9" href="http://www.washington.edu/ima" target="_blank"></a>--}}
        {{--<a class="icon icon10" href="http://www.urec.wsu.edu/events/pac-12-challenge/" target="_blank"></a>--}}
        {{--<a class="icon icon11" href="http://www.colorado.edu/recreation" target="_blank"></a>--}}
        {{--<a class="icon icon12" href="http://campusrec.utah.edu/" target="_blank"></a>--}}
    </div>
    <p>For PAC-12 Challenge Events On Your Campus.</p>
</div>

<div class="section s3">
    <img src="{{ asset('assets/images/section-3.png') }}" alt="" class="section-divider">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="section-image">
                {!! $page->get_module_by_number(3) !!}
            </div>
        </div>
    </div>
</div>
<div class="section s6">
    <img src="{{ asset('assets/images/section-3.png') }}" alt="" class="section-divider">
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <div class="section-image">
                {!! $page->get_module_by_number(4) !!}
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="area">
                {!! $page->get_module_by_number(5) !!}
                <a class="btn btn-primary" href="/past-challenges">View Previous Champions</a>
            </div>
        </div>
    </div>
</div>
<?php
    // Ensure at least one sponsor is published
    $valid_sponsors = false;
    foreach(Sponsor::all() as $sponsor) {
        if($sponsor->is_published()) {
            $valid_sponsors = true;
        }
    }
?>
@if($valid_sponsors)
    <div class="section sponsors">
        <img src="{{ asset('assets/images/section-3.png') }}" alt="" class="section-divider">
        <div class="row">
            <div class="col-sm-12">
                <div class="area">
                    <ul class="list-sponsors">
                    @foreach (Sponsor::all() as $sponsor)
                        @if($sponsor->is_published())
                                <li>
                            @if ($sponsor->url)
                                <a href="{{ $sponsor->url }}" target="_blank">
                                    @endif

                                    {{--<h3 class="sponsor-title">{{ $sponsor->name }}</h3>--}}
                                @if ($sponsor->banner)
                                        <img class="sponsor-banner" src='{{ asset($sponsor->banner) }}' alt=''>
                                    @elseif($sponsor->video)
                                        {{ $sponsor->video }}
                                    @endif

                                @if ($sponsor->url)
                                </a>
                            @endif
                        </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="section s7">
    <img src="{{ asset('assets/images/section-7.png') }}" alt="">
</div>
@stop

@section('footer')
    @include('footer')
@stop
