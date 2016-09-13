@extends('template')

@section('title', 'Sign Up')

@section('header')
    @include('header')
@stop

@section('content')
{{ Form::open() }}
    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            @include('alerts')
            <h1>Sign Up</h1>
            <p>
                <strong>Email</strong>
            </p>
            <p>
                <em>{{ Auth::user()->email }}</em>
            </p>
            <div class="form-group">
                {{ Form::label('school', 'School') }}
                {{ Form::select('school', School::schools(), null, array('class'=>'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password', 'autofocus')) }}
            </div>
            <div class="form-group">
                {{ Form::label('password_confirmation', 'Confirm Password') }}
                {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
            </div>
            <p class="text-right">
                <input type="submit" class="btn btn-success" value="Done" />
            </p>
        </div>
    </div>
{{ Form::close() }}
@stop

@section('footer')
    @include('footer')
@stop