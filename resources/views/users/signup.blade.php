@extends('template')

@section('title', 'Sign Up')

@section('css')
{{ HTML::style('assets/css/users/signup.css?v=' . VERSION) }}
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
            {{ Form::open() }}
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
            {{ Form::close() }}
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-md-1 fb-signup-margin text-center">
            - OR -
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-md-2 fb-signup-margin text-center">
            <?php
                $facebook = new Facebook(Config::get('facebook'));
    
                $login_params = array(
                    'scope' => 'email',
                    'redirect_uri' => URL::to('/signup-fb')
                );
            ?>
            <a class="btn btn-primary" href="{{$facebook->getLoginUrl($login_params)}}">Facebook Signup</a>
        </div>
    </div>
@stop

@section('footer')
    @include('footer')
@stop