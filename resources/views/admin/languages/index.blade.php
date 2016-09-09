@extends('admin.template')

@section('title', 'Languages')

@section('content')
<div class="row pad">
    <div class="col-sm-8 pad">
        <h1>Languages</h1>
        <a class="btn btn-sm btn-primary" href="{{ URL::to('admin/languages/add') }}">
            <span class="glyphicon glyphicon-plus"></span>
            Add
        </a>
    </div>
</div>
<div class="row text-center">
    {{ $links }}
</div>
<div class="row">
    <div class="col-sm-6">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>URI</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
            @foreach($languages as $language)
                <tr{{ $language->deleted_at ? ' class="deleted"' : '' }}>
                    <td>
                        <a href="{{ URL::to('admin/languages/edit/' . $language->id) }}" class="btn btn-xs btn-default">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                    </td>
                    <td>{{ $language->id }}</td>
                    <td>{{ $language->uri }}</td>
                    <td>{{ $language->name }}</td>
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