@extends('template')

@section('title', 'PAC-12 Challenge')

@section('css')
@stop

@section('js')
@stop

@section('header')
    @include('header')
@stop

@section('content')
<div class="pad text-center">
    <div class="col-md-6 col-md-offset-3">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Activity</th>
                    <th class="text-center">Minutes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $workout->date }}</td>
                    <td>{{ $workout->activity() }}</td>
                    <td>{{ $workout->minutes }}</td>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop

@section('footer')
    @include('footer')
@stop
