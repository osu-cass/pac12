@extends('template')

@section('title', 'Forgot Password')

@section('css')
{{ HTML::style('assets/css/users/signin.css?v=' . VERSION) }}
@stop

@section('header')
	@include('header')
@stop

@section('content')
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4">
			{{ Form::open() }}
			@include('alerts')
			<h1>Forgot Your Password?</h1>
			<p>Enter your email and we'll send you a link to reset your password.</p>
			<div class="form-group">
				{{ Form::label('email', 'Email') }}
				{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email', 'autofocus')) }}
			</div>
			<p class="text-left">
				<input type="submit" class="btn btn-success" value="Submit" />
			</p>
			{{ Form::close() }}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop