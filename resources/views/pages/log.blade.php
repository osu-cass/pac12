@extends('template')

@section('title', 'PAC-12 Challenge')

@section('css')
{{ HTML::style('assets/css/pages/account.css') }}
{{ HTML::style('assets/js/jquery/jquery.datetimepicker.css') }}
@stop

@section('js')
{{ HTML::script('assets/js/jquery/jquery.datetimepicker.js') }}
<script>
    $(document).ready(function() {
        // Date / time picker
        $('.date').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            formatDate: 'Y-m-d',
            minDate: '{{ explode(' ', $challenge->published_start)[0] }}',
            maxDate: '{{ explode(' ', $challenge->published_end)[0] }}'
        });

    });
</script>
@stop

@section('header')
    @include('header')
@stop

<?php

$activities = array();

$activities['cardio'] = array(
    '' => 'Select...',
    'Adaptive Motor Trainer' => 'Adaptive Motor Trainer',
    'Arctrainer' => 'Arctrainer',
    'Climber' => 'Climber',
    'Climbmill' => 'Climbmill',
    'Crossover' => 'Crossover',
    'Elliptical' => 'Elliptical',
    'Krankcycle' => 'Krankcycle',
    'Recumbent Bike' => 'Recumbent Bike',
    'Rower' => 'Rower',
    'Spin Cycle' => 'Spin Cycle',
    'Stepmill' => 'Stepmill',
    'Stepper' => 'Stepper',
    'Summit Trainer' => 'Summit Trainer',
    'Synchro' => 'Synchro',
    'Treadmill' => 'Treadmill',
    'Upright Bike' => 'Upright Bike'
);

$activities['sports'] = array(
    '' => 'Select...',
    'Aerobics' => 'Aerobics',
    'Aikido' => 'Aikido',
    'Alpine Skiing' => 'Alpine Skiing',
    'Backpacking' => 'Backpacking',
    'Badminton' => 'Badminton',
    'Ballroom Dancing' => 'Ballroom Dancing',
    'Baseball' => 'Baseball',
    'Basketball' => 'Basketball',
    'Bicycling' => 'Bicycling',
    'Boot Camp' => 'Boot Camp',
    'Bowling' => 'Bowling',
    'Boxing' => 'Boxing',
    'Calisthenics' => 'Calisthenics',
    'Canoeing' => 'Canoeing',
    'Circuit Training' => 'Circuit Training',
    'Climbing' => 'Climbing',
    'Cricket' => 'Cricket',
    'Crosscountry Skiiing' => 'Crosscountry Skiiing',
    'Crossfit' => 'Crossfit',
    'Cycling' => 'Cycling',
    'Dancing' => 'Dancing',
    'Diving' => 'Diving',
    'Fencing' => 'Fencing',
    'Frisbee' => 'Frisbee',
    'Golf' => 'Golf',
    'Gymnastics' => 'Gymnastics',
    'Handball' => 'Handball',
    'Hiking' => 'Hiking',
    'Hockey' => 'Hockey',
    'Horseback Riding' => 'Horseback Riding',
    'Housework' => 'Housework',
    'Ice Skating' => 'Ice Skating',
    'Jazzercize' => 'Jazzercize',
    'Jogging' => 'Jogging',
    'Judo' => 'Judo',
    'Jumping Rope' => 'Jumping Rope',
    'Karate' => 'Karate',
    'Kayaking' => 'Kayaking',
    'Kickball' => 'Kickball',
    'Kickboxing' => 'Kickboxing',
    'Kiteboarding' => 'Kiteboarding',
    'Lacross' => 'Lacross',
    'Martial Arts' => 'Martial Arts',
    'Mountain Biking' => 'Mountain Biking',
    'Mountaineering' => 'Mountaineering',
    'Orienteering' => 'Orienteering',
    'Paddleboarding' => 'Paddleboarding',
    'Pilates' => 'Pilates',
    'Racquetball' => 'Racquetball',
    'Rock Climbing' => 'Rock Climbing',
    'Rollerblading' => 'Rollerblading',
    'Rowing' => 'Rowing',
    'Rugby' => 'Rugby',
    'Running' => 'Running',
    'Scuba' => 'Scuba',
    'Skating' => 'Skating',
    'Snorkelling' => 'Snorkelling',
    'Snowboarding' => 'Snowboarding',
    'Snowshoeing' => 'Snowshoeing',
    'Soccer' => 'Soccer',
    'Softball' => 'Softball',
    'Squash' => 'Squash',
    'Stair Climbing' => 'Stair Climbing',
    'Step Aerobics' => 'Step Aerobics',
    'Strength Training' => 'Strength Training',
    'Surfing' => 'Surfing',
    'Swimming' => 'Swimming',
    'Taekwondo' => 'Taekwondo',
    'Tai Chi' => 'Tai Chi',
    'Telemark Skiing' => 'Telemark Skiing',
    'Tennis' => 'Tennis',
    'Track And Field' => 'Track And Field',
    'Trail Running' => 'Trail Running',
    'Trekking' => 'Trekking',
    'Volleyball' => 'Volleyball',
    'Walking' => 'Walking',
    'Water Aerobics' => 'Water Aerobics',
    'Water Polo' => 'Water Polo',
    'Water Skiiing' => 'Water Skiiing',
    'Wind Surfing' => 'Wind Surfing',
    'Wrestling' => 'Wrestling',
    'Yardwork' => 'Yardwork',
    'Yoga' => 'Yoga',
    'Zumba' => 'Zumba',

);

$activities['strength'] = array(
    '' => 'Select...',
    'Abdominal' => 'Abdominal',
    'Angled Leg Press' => 'Angled Leg Press',
    'Arm Curl' => 'Arm Curl',
    'Arm Extension' => 'Arm Extension',
    'Back Extension' => 'Back Extension',
    'Bench Press' => 'Bench Press',
    'Bicep Curls' => 'Bicep Curls',
    'Calf Extension' => 'Calf Extension',
    'Chest Press' => 'Chest Press',
    'Chin Assist' => 'Chin Assist',
    'Dip' => 'Dip',
    'Fly' => 'Fly',
    'Glute Extension' => 'Glute Extension',
    'Hack Slide' => 'Hack Slide',
    'Hack Squat' => 'Hack Squat',
    'Hip Abduction' => 'Hip Abduction',
    'Incline Press' => 'Incline Press',
    'Inner Pulldown' => 'Inner Pulldown',
    'Inner Thigh' => 'Inner Thigh',
    'Lat Pulldown' => 'Lat Pulldown',
    'Lateral Raise' => 'Lateral Raise',
    'Leg Curl' => 'Leg Curl',
    'Leg Extension' => 'Leg Extension',
    'Leg Press' => 'Leg Press',
    'Low Row' => 'Low Row',
    'Outer Thigh' => 'Outer Thigh',
    'Overhead Press' => 'Overhead Press',
    'Pec Fly' => 'Pec Fly',
    'Prone Leg Curl' => 'Prone Leg Curl',
    'Pulldown' => 'Pulldown',
    'Rear Delt' => 'Rear Delt',
    'Rotary Torso' => 'Rotary Torso',
    'Row' => 'Row',
    'Seated Calf' => 'Seated Calf',
    'Seated Dip' => 'Seated Dip',
    'Seated Leg Curl' => 'Seated Leg Curl',
    'Seated Row' => 'Seated Row',
    'Shoulder Press' => 'Shoulder Press',
    'Smith Press' => 'Smith Press',
    'Standing Calf' => 'Standing Calf',
    'Super Squat' => 'Super Squat',
    'Torso Rotation' => 'Torso Rotation',
    'Triceps Extension' => 'Triceps Extension',
    'Triceps Press' => 'Triceps Press',
);


$types = array(
    '' => 'Select Type...',
    'cardio' => 'Cardio',
    'strength' => 'Strength/Resistance Training',
    'mind' => 'Mind/Body',
    'sports' => 'Sports & Fitness',
);

?>

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
        <li class=""><a href="{{ URL::to('account') }}">Details</a></li>
        <li class=""><a href="{{ URL::to('workouts') }}">Workouts</a></li>
        <li class="active"><a href="{{ URL::to('log') }}">Log Workout</a></li>
        <li class=""><a href="{{ URL::to('badges') }}">Badges</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        {{ Form::open(array('url'=>'post-time')) }}
            <table class="table">
                <tbody>
                    <tr>
                        <td class="text-center">{{ Form::label('activity', 'Activity') }}</td>
                        <td>
                            {{ Form::select('type', $types, '', array('class'=>'form-control', 'id' => 'type')) }}
                        </td>
                    </tr>
                    <tr class="weightField">
                        <td class="text-center">{{ Form::label('weight', 'Weight') }}</td>
                        <td>
                            {{ Form::text('weight', null, array('class'=>'form-control', 'placeholder'=>'Weight', 'style'=>'width:100px;display:inline-block;')) }}
                            <span style="margin-left:15px;"><b>lbs</b></span>
                        </td>
                    </tr>
                    <tr class="weightField">
                        <td class="text-center">{{ Form::label('reps', 'Reps') }}</td>
                        <td>
                            {{ Form::text('reps', null, array('class'=>'form-control', 'placeholder'=>'Reps', 'style'=>'width:100px;display:inline-block;')) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">{{ Form::label('minutes', 'Time') }}</td>
                        <td>
                            {{ Form::text('minutes', null, array('class'=>'form-control', 'placeholder'=>'Time', 'style'=>'width:100px;display:inline-block;')) }}
                            <span style="margin-left:15px;"><b>minutes</b></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">{{ Form::label('date', 'Date') }}</td>
                        <td >
                            {{ Form::text('date', null, array('class'=>'form-control date', 'placeholder'=>'Date')) }}
                            <span style="margin-left:15px;"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pad text-right">
                <input type="submit" class="btn btn-primary" value="Submit" />
            </div>
        {{ Form::close() }}
    </div>
</div>
@stop

@section('footer')
    @include('footer')
@stop
