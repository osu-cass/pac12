@extends('template')

@section('title', 'Sign In')

@section('css')
{{ HTML::style('assets/css/users/signin.css') }}
@stop

@section('header')
    @include('header')
@stop

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4">
            {{ Form::open() }}
            @include('alerts')
            <h1>Sign In</h1>
            <div class="form-group">
                {{ Form::label('signemail', 'Email') }}
                {{ Form::text('signemail', null, array('class'=>'form-control', 'placeholder'=>'Email', 'autofocus')) }}
            </div>
            <div class="form-group">
                {{ Form::label('signpass', 'Password') }}
                {{ Form::password('signpass', array('class'=>'form-control', 'placeholder'=>'Password')) }}
            </div>
            <p class="text-left">
                <input type="submit" class="btn btn-success" value="Submit" />
                <?php
                    $facebook = new Facebook(Config::get('facebook'));
                    $helper = $facebook->getRedirectLoginHelper();
                    $params = array(
                        'scope' => 'email',
                        'redirect_uri' => URL::to('/signin-fb')
                    );
                ?>
                <a class="btn btn-primary fb-signin" href="{{$helper->getLoginUrl($params)}}">FB Login</a>
            </p>
            {{ Form::close() }}
        </div>
    </div>

<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4">
        <h1>Need an account?</h1>
        <p>
            <a class="btn btn-primary" href="{{ URL::to('signup') }}">Sign Up</a>
        </p>
        <p>
            <a href="/forgot-password">Forgot your password?</a>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4">

    </div>
</div>
@stop

@section('footer')
    @include('footer')
@stop
