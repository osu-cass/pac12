@extends('admin.template')

@section('title', 'Add User')

<?php

?>

@section('content')
<h1>Add User</h1>
<div class="row">
    <div class="col-md-7 col-sm-8">
        {{ Form::open(array('role'=>'form', 'method'=>'post')) }}
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>
                            {{ Form::label('type', 'Type') }}
                        </td>
                        <td>
                            {{ Form::select('type', $okay_types, 'user', array('class' => 'form-control')) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('email', 'Email') }}
                        </td>
                        <td>
                            {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email', 'autofocus')) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('school', 'School') }}
                        </td>
                        <td>
                            {{ Form::select('school', School::schools(), null, array('class'=>'form-control', 'placeholder'=>'Email', 'autofocus')) }}
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
                <input type="submit" class="btn btn-primary" value="Save" />
            </div>
        {{ Form::close() }}
    </div>
</div>
@stop