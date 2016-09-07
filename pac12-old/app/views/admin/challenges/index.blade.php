@extends('admin.template')

@section('title', 'Challenges')

@section('js')
@stop

@section('content')
	<div class="row pad">
		<div class="col-sm-8 pad">
			<h1>Challenges</h1>
			<a class="btn btn-sm btn-primary" href="{{ url('admin/challenges/add') }}">
				<span class="glyphicon glyphicon-plus"></span>
				Add
			</a>
		</div>
		<div class="col-sm-4 well">
			{{ Form::open(array('role'=>'form', 'method'=>'get')) }}
				<div class="form-group">
					<label>Search</label>
					<input type="text" name="search" class="form-control" value="{{ $search }}" />
				</div>
				<div class="text-right">
					<input type="submit" class="btn btn-primary" value="Search" />
				</div>
			{{ Form::close() }}
		</div>
	</div>
	<div class="row text-center">
		{{ $links }}
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-striped">
				<thead>
					<tr>
						<th style="width:80px;"></th>
						<th style="width:80px;">ID</th>
						<th style="width:200px;">Dates</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
				@foreach($challenges as $challenge)
					<tr{{ $challenge->deleted_at ? ' class="deleted"' : '' }}>
						<td>
							<a href="{{ url('admin/challenges/edit/' . $challenge->id) }}" class="btn btn-xs btn-default">
								<span class="glyphicon glyphicon-edit"></span>
							</a>
						</td>
						<td>{{ $challenge->id }}</td>
						<td>{{ date('M d, Y', strtotime($challenge->published_start)) . ' - ' .  date('M d, Y', strtotime($challenge->published_end))}}</td>
						<td>{{ $challenge->name }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row text-center">
		{{ $links }}
	</div>
@stop