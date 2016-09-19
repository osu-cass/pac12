@extends('template')

@section('title', 'Fitness Challenge')

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
            title: {
                text: 'STUDENTS WHO HAVE LOGGED WORKOUTS'
            },
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: {
                    show: true,
                    formatString: '%d'
                }
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
                        drawBaseline: false,
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
            {{ $totals[0]->students }},
            {{ $totals[1]->students }},
            {{ $totals[2]->students }},
            {{ $totals[3]->students }},
            {{ $totals[4]->students }},
            {{ $totals[5]->students }},
            {{ $totals[6]->students }},
            {{ $totals[7]->students }},
            {{ $totals[8]->students }},
            {{ $totals[9]->students }},
            {{ $totals[10]->students }},
            {{ $totals[11]->students }}
        ];
        var plot0 = $.jqplot('chart', [plot0Data], options);

        @if(Carbon::now()->toDateString() == $end|| Input::get('graphs'))
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

    // jqPlot is stupid
    @if(isset($countdown))
    var canvas = document.getElementById('countdown-bar');
    var context = canvas.getContext('2d');
    var countdown_total = {{ $countdown }};

    var bar_width = (countdown_total / 2000000) * canvas.width;
    var bar_height = canvas.height;

    // Draw countdown bar
    context.fillStyle = "blue";
    context.fillRect(0, 0, bar_width, bar_height);
    context.fillStyle = "white";
    context.fillRect(5, 5, bar_width - 10, bar_height - 10);

    @endif
</script>
@stop

@section('header')
    @include('header')
@stop

@section('content')
<div class="section chart<?php
if (time() < $start && !Input::get('graphs')) {
    echo ' cripple';
}
?>">
    <div id="chart">
    </div>
    <div id="chartLabels">
        <img src="{{ URL::to('assets/images/graph-labels.png') }}" />
    </div>
    @if(isset($countdown))
    <div id="countdown">
        <canvas id="countdown-bar" width="1000" height="50">
            Your browser doesn't support the HTML5 Canvas element
        </canvas>
        <h3 style="color: white;" align="center">{{ 2000000 - $countdown }} minutes logged so far!</h3>
        <h3 style="color: white;" align="center">{{ $countdown }} minutes to go!</h3>
    </div>
    @if($countdown == 0)
    <div id="countdown-finished">
        <h2>We've reached the goal of 2,000,000 minutes!</h2>
    </div>
    @endif
    @endif
</div>
<div id="header-sub">
    @include('alerts')
    <h1>PAC-12 RECREATION CHALLENGE</h1>
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
                    <p>{!! $challenge->description !!}</p>
                </div>
            </div>
        </div>
    </div>
@endif
@if(Carbon::now() == $end|| Input::get('graphs'))
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
    </div>
    <p>For Pac-12 Recreation Challenge Events On Your Campus.</p>
</div>

<div class="section s5">
    <img src="{{ asset('assets/images/section-3.png') }}" alt="" class="section-divider">
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <div class="area">
                {!! $page->get_module_by_number(2) !!}
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
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
