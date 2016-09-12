@extends('admin.template')

@section('title', ucfirst($action).' School')

@section('css')
@stop

@section('js')
@stop

@section('content')
    <h1>{{ ucfirst($action) }} School</h1>

    @if ($action == 'edit')
        {{ Form::model($school) }}
    @elseif ($action == 'add')
        {{ Form::open(array('role'=>'form', 'method'=>'post')) }}
    @endif

    <div class="row">
        <div class="col-md-9">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>
                            {{ Form::label('name', 'Name') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ $school->name }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('url', 'URL') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ Form::text('url', null, array('class'=>'form-control', 'placeholder'=>'URL')) }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>{{-- Left Column --}}
        </div>
    </div>{{-- Row --}}
    <div class="text-right pad">
        <input type="submit" class="btn btn-primary" value="Save" />
    </div>
    {{ Form::close() }}
@stop
