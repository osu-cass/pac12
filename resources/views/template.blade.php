<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/iphone-icon.png') }}"/>
    <title>PAC12 | @yield('title')</title>

    {{ HTML::style('//netdna.bootstrapcdn.com/bootswatch/3.0.1/spacelab/bootstrap.min.css') }}
    {{ HTML::style('assets/css/master.css?v=' . VERSION) }}
    
    @yield('css')
</head>
<body>
<div id="masterContainer">
    @yield('header')
    @yield('content')
    @yield('footer')
</div><!-- Master Container -->
{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') }}
{{ HTML::script('//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js') }}
<!-- {{ HTML::script('assets/js/facebook.js') }} -->
<script type="text/javascript" src="//use.typekit.net/kur3rnk.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script>
    var config = {
        base_url: "{{ URL::to('/') }}/"
    };
</script>
@yield('js')
</body>
</html>
