@extends('template')

@section('title', 'PAC12 Challenge')

@section('css')
    {{ HTML::style('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css') }}
    {{ HTML::style('assets/css/pages/account.css') }}
@stop

@section('js')
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js') }}
    <script>
        $(function() {
            $(".datePicker").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0',
                defaultDate: '1970-01-01'
            });
            toggle_gender();
            $('#gender').change(function(){
                toggle_gender();
            });
        });
        function toggle_gender() {
            var gender = $('#gender').val();
            if(gender == 'o') $('#gender_other').show();
            else $('#gender_other').hide();
        }
    </script>
@stop

@section('header')
    @include('header')
@stop

@section('content')
<a class="btn btn-warning signout" href="{{ URL::to('signout') }}">
    Sign Out
</a>
<div class="pad text-center">
    @include('alerts')
    <h1>MY ACCOUNT</h1>
</div>
<div class="pad text-center">
    <ul class="nav nav-pills" style="display:inline-block;">
        <li class="active"><a href="{{ URL::to('account') }}">Details</a></li>
        <li class=""><a href="{{ URL::to('workouts') }}">Workouts</a></li>
        <li class=""><a href="{{ URL::to('log') }}">Log Workout</a></li>
        <li class=""><a href="{{ URL::to('badges') }}">Badges</a></li>
    </ul>
</div>
<div class="pad text-center">
    <div class="col-md-6 col-md-offset-3">
        {{ Form::model(Auth::user()) }}
            <table class="table">
                <tbody>
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
                            {{ Form::label('dob', 'Date of Birth') }}
                        </td>
                        <td>
                            {{ Form::text('dob', null, array('class'=>'form-control datePicker', 'placeholder'=>'Date of Birth')) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('gender', 'Gender') }}
                        </td>
                        <td>
                            {{ Form::select('gender', array(
                                'm' => 'Male',
                                'f' => 'Female',
                                't' => 'Transgender',
                                'u' => 'Multiple Gender',
                                'o' => 'Other',
                                'n' => 'Choose not to identify',
                            ), null, array('class' => 'form-control')) }}
                            {{ Form::text('gender_other', null, array('class'=>'form-control', 'placeholder'=>'Other','style' => 'display:none;margin-top:8px;','id' => 'gender_other')) }}
                        </td>
                    </tr>
                    <!--tr>
                        <td>
                            {{ Form::label('weight', 'Weight') }}
                        </td>
                        <td class="text-left">
                            {{ Form::text('weight', null, array('class'=>'form-control', 'placeholder'=>'Weight', 'style'=>'width:100px;display:inline-block;')) }}
                            <span style="margin-left:15px;"><b>pounds</b></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Height</b>
                        </td>
                        <td class="text-left">
                            {{ Form::select('height_feet', array(
                                '3' => '3\'',
                                '4' => '4\'',
                                '5' => '5\'',
                                '6' => '6\'',
                                '7' => '7\''
                            ), null, array('class' => 'form-control', 'style'=>'width:auto;display:inline-block;')) }}
                            {{ Form::select('height_inches', array(
                                '0' => '0"',
                                '1' => '1"',
                                '2' => '2"',
                                '3' => '3"',
                                '4' => '4"',
                                '5' => '5"',
                                '6' => '6"',
                                '7' => '7"',
                                '8' => '8"',
                                '9' => '9"',
                                '10' => '10"',
                                '11' => '11"',
                            ), null, array('class' => 'form-control', 'style'=>'width:auto;display:inline-block;')) }}
                        </td>
                    </tr-->
                </tbody>
            </table>
            <div class="text-right pad">
                <input type="submit" class="btn btn-primary" value="Save" />
            </div>
        {{ Form::close() }}
    </div>
</div>
<div class="pad text-center">
    <div class="col-md-6 col-md-offset-3">
        {{ Form::open(array('url' => 'change-password')) }}
        <p>Change Password</p>
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            {{ Form::label('password', 'New Password') }}
                        </td>
                        <td>
                            {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'New Password')) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('confirm', 'Confirm Password') }}
                        </td>
                        <td>
                            {{ Form::password('confirm', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
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

@section('footer')
    @include('footer')
@stop
