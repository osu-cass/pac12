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
    });
</script>
@stop

@section('header')
    @include('header')
@stop

@section('content')
<div class="section chart">
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
                    <p>{!! $challenge->description !!}</p>
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
