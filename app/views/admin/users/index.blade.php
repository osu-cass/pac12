@extends('admin.template')

@section('title', 'Users')

@section('content')
{{ Form::open(array('role'=>'form', 'method'=>'get')) }}
	<div class="row pad">
		<div class="col-sm-8 pad">
			<h1>Users</h1>
			<a class="btn btn-sm btn-primary" href="{{ URL::to('admin/users/add') }}">
				<span class="glyphicon glyphicon-plus"></span>
				Add
			</a>
		</div>
		<div class="col-sm-4 well">
			<div class="form-group">
				<label>Search</label>
				<input type="text" name="search" class="form-control" value="{{ $search }}" />
			</div>
			<div class="text-right">
				<input type="submit" class="btn btn-primary" value="Search" />
			</div>
		</div>
	</div>
{{ Form::close() }}
<div class="row text-center">
	{{ $links }}
</div>
<div class="row">
	<table class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th>ID</th>
				<th>Type</th>
				<th>Email</th>
				<th>Username</th>
			</tr>
		</thead>
		<tbody>
		@foreach($users as $user)
			<tr{{ $user->deleted_at ? ' class="deleted"' : '' }}>
				<td>
					<a href="{{ URL::to('admin/users/edit/' . $user->id) }}" class="btn btn-xs btn-default">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				</td>
				<td>{{ $user->id }}</td>
				<td>{{ $user->type }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->username }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
<div class="row text-center">
	{{ $links }}
</div>
@stop