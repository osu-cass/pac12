@extends('admin.template')

@section('title', 'Badges')

@section('js')
@stop

@section('content')
	<div class="row pad">
		<div class="col-sm-8 pad">
			<h1>Badges</h1>
			<a class="btn btn-sm btn-primary" href="{{ url('admin/badges/add') }}">
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
						<th style="width:100px;">Icon</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
				@foreach($badges as $badge)
					<tr{{ $badge->deleted_at ? ' class="deleted"' : '' }}>
						<td>
							<a href="{{ url('admin/badges/edit/' . $badge->id) }}" class="btn btn-xs btn-default">
								<span class="glyphicon glyphicon-edit"></span>
							</a>
						</td>
						<td><img src="{{ asset($badge->icon) }}" style="max-height: 80px; max-width: 80px; height: auto; width: auto"></td>
						<td>{{ $badge->name }}</td>
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