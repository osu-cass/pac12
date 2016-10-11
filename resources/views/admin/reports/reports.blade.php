@extends('admin.template')

@section('title', 'Reports')

@section('css')
{{ HTML::style('assets/js/jquery/jquery.datetimepicker.css') }}
@stop

@section('js')
{{ HTML::script('assets/jqplot/jquery.jqplot.min.js') }}
{{ HTML::script('assets/jqplot/plugins/jqplot.barRenderer.min.js') }}
{{ HTML::script('assets/jqplot/plugins/jqplot.categoryAxisRenderer.min.js') }}
{{ HTML::script('assets/jqplot/plugins/jqplot.pieRenderer.min.js') }}
{{ HTML::script('assets/jqplot/plugins/jqplot.pointLabels.min.js') }}
{{ HTML::script('assets/js/jquery/jquery.datetimepicker.js') }}


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
            plot0Options.axes.xaxis.ticks = [
                @foreach ($totals as $total)
                '{{ substr($total->date, 5) }}',
                @endforeach
            ];
            var plot0Data = [
                @foreach ($totals as $total)
                {{ ($total->minutes ?  $total->minutes : 0) }},
                @endforeach
    ];
    var plot0 = $.jqplot('chart', [plot0Data], options);

    });
</script>

<script>
    $(document).ready(function() {
        // Date / time picker
        $('.date').datetimepicker({
            format: 'Y-m-d',
            timepicker: false
        });
    });
</script>
@stop

@section('content')
<div class="row">
    <div class="col-sm-8 pad">
        <h1>Reports</h1>
        <h3>{{ $heading }}</h3>
        <div class="section chart<?php
        if (time() < strtotime('2014-02-24') && !Input::get('graphs')) {
            echo ' cripple';
        }
        ?>">
            <div id="chart" style="width:1000px;">
            </div>
        </div>
        <div class="col-sm-4 pad">
            <h3>Individual Day Reports</h3>
            @foreach ($dates as $date)
            <p>
                <a href="/admin/report/{{ $date }}">
                    {{ $date }}
                </a>
            </p>
            @endforeach
        </div>
        <div class="col-sm-4 pad">
            {{ Form::open(array('url' => '/admin/report/range')) }}
            <h3>Select Date Range</h3>
            {{ Form::label('start', 'Start Date') }}
            {{ Form::text('start', null, array('class'=>'form-control date', 'placeholder'=>'Start Date')) }}
            <br>
            {{ Form::label('end', 'End Date') }}
            {{ Form::text('end', null, array('class'=>'form-control date', 'placeholder'=>'End Date')) }}
            <br>
            <div class="text-right pad">
                <input type="submit" class="btn btn-primary" value="Submit" />
            </div>
            <div class="text-right pad">
                <a href="/admin/reports" class="btn btn-primary">Back to Challenge to Date</a>
            </div>

            {{ Form::close() }}
        </div>
    </div>

</div>
@stop