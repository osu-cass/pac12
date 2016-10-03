@extends('admin.template')

@section('title', 'Add User')

@section('content')
<div class="row">
    <div class="col-md-7 col-sm-8">
        <h1>Edit User</h1>
        @if ($edit_user != Auth::user())
            @if (!$edit_user->deleted_at)
                {{ Form::open(array('role'=>'form',
                                    'url'=>'admin/users/delete/'.$edit_user->id,
                                    'style'=>'margin-bottom:15px;')) }}
                    <input type="submit" class="btn btn-sm btn-danger" value="Delete" />
                {{ Form::close() }}
            @else
                {{ Form::open(array('role'=>'form',
                                    'url'=>'admin/users/hard-delete/'.$edit_user->id,
                                    'class'=>'deleteForm',
                                    'data-confirm'=>'Delete this user forever?')) }}
                    <input type="submit" class="btn btn-sm btn-danger" value="Delete Forever" />
                {{ Form::close() }}
                <a href="{{ URL::to('admin/users/restore/'.$edit_user->id) }}" class="btn btn-sm btn-success">Restore</a>
            @endif
        @endif
        {{ Form::model($edit_user) }}
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>
                            {{ Form::label('type', 'Type') }}
                        </td>
                        <td>
                            {{ Form::select('type', $okay_types, null, array('class' => 'form-control')) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('email', 'Email') }}
                        </td>
                        <td>
                            {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email')) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('username', 'Username') }}
                            <br />(4 - 16 characters)
                        </td>
                        <td>
                            {{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Username')) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('school_id', 'School') }}
                        </td>
                        <td>
                            {{ Form::select('school_id', School::schools(), null, array('class'=>'form-control', 'autofocus')) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-right pad">
                <input type="submit" class="btn btn-primary" value="Save" />
            </div>
        {{ Form::close() }}
        <h3>Password Reset</h3>
        {{ Form::open(array('role'=>'form', 'url'=>'admin/users/password/'.$edit_user->id)) }}
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>
                            {{ Form::label('password', 'Password') }}
                            <br />(Min. 6 characters)
                        </td>
                        <td>
                            {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('password_confirmation', 'Confirm Password') }}
                        </td>
                        <td>
                            {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-right pad">
                <input type="submit" class="btn btn-primary" value="Reset Password" />
            </div>
        {{ Form::close() }}
    </div>
</div>
@stop
