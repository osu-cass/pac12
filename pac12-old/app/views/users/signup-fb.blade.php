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
			<div class="form-group">
				{{ Form::label('school', 'School') }}
				{{ Form::select('school', School::schools(), null, array('class'=>'form-control')) }}
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