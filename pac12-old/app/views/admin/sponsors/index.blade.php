@extends('admin.template')

@section('title', 'Sponsors')

@section('js')
@stop

@section('content')
	<div class="row pad">
		<div class="col-sm-8 pad">
			<h1>Sponsors</h1>
			<a class="btn btn-sm btn-primary" href="{{ url('admin/sponsors/add') }}">
				<span class="glyphicon glyphicon-plus"></span>
				Add
			</a>
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
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
				@foreach($sponsors as $sponsor)
					<tr{{ $sponsor->deleted_at ? ' class="deleted"' : '' }}>
						<td>
							<a href="{{ url('admin/sponsors/edit/' . $sponsor->id) }}" class="btn btn-xs btn-default">
								<span class="glyphicon glyphicon-edit"></span>
							</a>
						</td>
						<td>{{ $sponsor->id }}</td>
						<td>{{ $sponsor->name }}</td>
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