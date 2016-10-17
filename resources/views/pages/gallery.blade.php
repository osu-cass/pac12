@extends('template')

@section('title', 'PAC12 Challenge')

@section('css')
    {{ HTML::style('assets/css/pages/account.css?v=' . VERSION) }}
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
        <li class=""><a href="{{ URL::to('badges') }}">Badges</a></li>
    </ul>
</div>
<div class="row text-center">
    <div class="col-md-6 col-md-offset-3">
        <table class="table">
            <tbody>
                <tr>
                    <td><b>Add Image</b></td>
                    <td>
                        <form role="form" method="post" action="{{ URL::to('images/upload') }}" enctype="multipart/form-data">
                            <input id="imageInput" type="file" name="image" />
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    @foreach (Auth::user()->images as $image)
        <div class="col-xs-3">
            <img src="{{ $image->url() }}" style="width:100%;" />
        </div>
    @endforeach
</div>
@stop

@section('footer')
    @include('footer')
@stop
