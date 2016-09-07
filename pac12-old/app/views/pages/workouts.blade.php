@extends('template')

@section('title', 'Fitness Challenge')

@section('css')
	{{ HTML::style('assets/jqplot/jquery.jqplot.min.css') }}
	{{ HTML::style('assets/css/pages/account.css?v=' . VERSION) }}
@stop

@section('js')
	{{ HTML::script('assets/jqplot/jquery.jqplot.min.js') }}
	{{ HTML::script('assets/jqplot/plugins/jqplot.barRenderer.min.js') }}
	{{ HTML::script('assets/jqplot/plugins/jqplot.categoryAxisRenderer.min.js') }}
	{{ HTML::script('assets/jqplot/plugins/jqplot.pieRenderer.min.js') }}
	{{ HTML::script('assets/jqplot/plugins/jqplot.pointLabels.min.js') }}
	{{ HTML::script('assets/jqplot/options.js') }}
	<script>
		$(document).ready(function() {
			$.jqplot.config.enablePlugins = true;
			var options = jqplot_options();

			// Vars
			var json = '{{ json_encode($workout_data) }}',
				workout_data = JSON && JSON.parse(json) || $.parseJSON(json), // Use jquery to parse json if the browser doesn't support JSON
				plotData = [];

			// Labels - Minutes
			for (date in workout_data) {
				options.axes.xaxis.ticks.push(workout_data[date].label);
				plotData.push(parseFloat(workout_data[date].minutes));
			}

			// Plot
			var plot = $.jqplot('chart', [plotData], options);
		});
	</script>
@stop

@section('header')
	@include('header')
@stop

@section('content')
<a class="btn btn-warning signout" href="{{ URL::to('signout') }}">
	Sign Out
</a>
<div class="pad text-center">
	@include('alerts')
	<h1>MY ACCOUNT</h1>
</div>
<div class="pad text-center">
	<ul class="nav nav-pills" style="display:inline-block;">
		<li class=""><a href="{{ URL::to('account') }}">Details</a></li>
		<li class="active"><a href="{{ URL::to('workouts') }}">Workouts</a></li>
		<li class=""><a href="{{ URL::to('log') }}">Log Workout</a></li>
		<li class=""><a href="{{ URL::to('badges') }}">Badges</a></li>
	</ul>
</div>
<div class="pad text-center">
	<div class="col-md-6 col-md-offset-3">
		<div id="chart">
		</div>
	</div>
</div>
<div class="pad text-center">
	<div class="col-md-6 col-md-offset-3">
		<table class="table">
			<thead>
				<tr>
					<th class="text-center">Date</th>
					<th class="text-center">Activity</th>
					<th class="text-center">Minutes</th>
					<th class="text-center">Share</th>
				</tr>
			</thead>
			<tbody>
				@foreach (Auth::user()->times as $time)
				<?php
					$share_text = rawurlencode($time->share_text());
				?>
				<tr>
					<td>{{ $time->date }}</td>
					<td>{{ $time->activity() }}</td>
					<td>{{ $time->minutes }}</td>
					<td>
						<ul class="menu-social">
							<li>
								<a class="fb" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($time->url()) }}" target="_blank"></a>
							</li>
							<li>
								<a class="tw" href="http://twitter.com/share?text={{ $share_text }}&url={{ urlencode($time->url()) }}" target="_blank"></a>
							</li>
							<li>
								<a class="gp" href="https://plus.google.com/share?url={{ urlencode($time->url()) }}" target="_blank"></a>
							</li>
							<li>
								<a class="in" href="http://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($time->url()) }}&summary={{ $share_text }}" target="_blank"></a>
							</li>
							<li>
								<a class="em" href="mailto:?body={{ $share_text }}" target="_blank"></a>
							</li>
						</ul>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop