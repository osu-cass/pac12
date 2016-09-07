<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Admin | @yield('title')</title>

	{{ HTML::style('//netdna.bootstrapcdn.com/bootswatch/3.0.1/spacelab/bootstrap.min.css') }}
	{{ HTML::style('assets/admin/master.css?v=' . VERSION) }}
	@yield('css')
</head>
<body>
<div id="adminMasterContainer" class="container">
	@if (Auth::check() && Session::get('admin'))
		@include('admin.header')
	@else
		@yield('header')
	@endif

	@include('alerts')
	@yield('content')
</div><!-- Master Container -->
{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') }}
{{ HTML::script('//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js') }}
<script>
	var config = {
		base_url: '{{ URL::to('/') }}/'
	};
</script>
{{ HTML::script('assets/admin/master.js?v=' . VERSION) }}
@yield('js')
</body>
</html>
