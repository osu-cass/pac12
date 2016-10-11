@extends('admin.template')

@section('title', 'Schools')

@section('js')
@stop

@section('content')
    <div class="row pad">
        <div class="col-sm-8 pad">
            <h1>Schools</h1>
            {{--<a class="btn btn-sm btn-primary" href="{{ url('admin/schools/add') }}">--}}
                {{--<span class="glyphicon glyphicon-plus"></span>--}}
                {{--Add--}}
            {{--</a>--}}
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
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($schools as $school)
                    <tr{{ $school->deleted_at ? ' class="deleted"' : '' }}>
                        <td>
                            <a href="{{ url('admin/schools/edit/' . $school->id) }}" class="btn btn-xs btn-default">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                        </td>
                        <td>{{ $school->name }}</td>
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