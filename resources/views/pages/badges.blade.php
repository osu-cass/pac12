@extends('template')

@section('title', 'Fitness Challenge')

@section('css')
{{ HTML::style('assets/css/pages/account.css') }}
@stop

@section('js')
<script>
    $('#imageInput').change(function() {
        $(this).closest('form').submit();
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
        <li class=""><a href="{{ URL::to('workouts') }}">Workouts</a></li>
        <li class=""><a href="{{ URL::to('log') }}">Log Workout</a></li>
        <li class="active"><a href="{{ URL::to('badges') }}">Badges</a></li>
    </ul>
</div>
<div class="row text-center">
    <div class="col-md-6 col-md-offset-3">
        <table class="table">
            <tbody>
            @foreach ($badges as $badge)
            <tr>
                <td style="width:80px;">
                    <img src="{{ asset($badge->icon) }}" style="max-height: 250px; max-width: 250px; height: auto; width: auto">
                </td>
                <td style="vertical-align: middle; text-align: left; width:500px;">
                    {{ $badge->name }}
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
