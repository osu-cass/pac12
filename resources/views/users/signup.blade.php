@extends('template')

@section('title', 'Sign Up')

@section('css')
{{ HTML::style('assets/css/users/signup.css') }}
@stop

@section('header')
    @include('header')
@stop

@section('content')
<div>
    {{ Session::get('message') }}
</div>
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-1">
            <?php
                if ($challenge == null) {
                    echo 'Registration is closed until the beginning of the next challenge. ';
                    echo 'Check back regularly for details of the next challenge!';
                }
            ?>
            {{ Form::open() }}
            <?php
                if ($challenge == null) {
                    echo '<fieldset disabled="disabled">';
                }
            ?>
                @include('alerts')
                <h1>Sign Up</h1>
                <div class="form-group">
                    {{ Form::label('school', 'School') }}
                    {{ Form::select('school', School::schools(), null, array('class'=>'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email', 'autofocus')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('email_confirmation', 'Confirm Email') }}
                    {{ Form::text('email_confirmation', null, array('class'=>'form-control', 'placeholder'=>'Confirm Email')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('password', 'Password') }}
                    {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('password_confirmation', 'Confirm Password') }}
                    {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
                </div>
                <p class="text-right">
                    <input type="submit" class="btn btn-success" value="Done" />
                </p>
            <?php
                if ($challenge == null) {
                    echo '</fieldset>';
                }
            ?>
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('footer')
    @include('footer')
@stop
