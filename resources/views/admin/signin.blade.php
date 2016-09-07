@extends('admin.template')

@section('title', 'Home')

@section('css')
    {{ HTML::style('assets/admin/signin.css' . '?v=' . VERSION) }}
@stop

@section('header')
    <div class="row">
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL::to('admin') }}">Admin</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ URL::to('signin') }}">Help</a></li>
                </ul>
            </div>
        </div>
    </div><!-- Header Row -->
@stop

@section('content')
<div class="row">
    <div class="loginForm">
        {{ Form::open(array('role'=>'form')) }}
            <h1>Sign In</h1>
            <div class="form-group">
                {{ Form::label('loguser', 'Username or Email', array('class'=>'sr-only')) }}
                {{ Form::text('loguser', null, array('class'=>'form-control', 'placeholder'=>'Username or Email', 'autofocus')) }}
            </div>
            <div class="form-group">
                {{ Form::label('logpass', 'Password', array('class'=>'sr-only')) }}
                {{ Form::password('logpass', array('class'=>'form-control', 'placeholder'=>'Password')) }}
            </div>
            <p class="text-right">
                <input type="submit" class="btn btn-primary" value="Sign In" />
            </p>
        {{ Form::close() }}
    </div>
</div>
@stop