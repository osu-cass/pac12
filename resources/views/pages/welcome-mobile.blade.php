@extends('template')

@section('title', 'PAC-12 Challenge')

@section('css')
{{ HTML::style('assets/css/pages/welcome-mobile.css?v=' . VERSION) }}
@stop

@section('js')
@stop

@section('content')
<div class="rule"></div>
<div id="header">
    @include('alerts')
    <h1>PAC-12 CHALLENGE</h1>
    <p>
        Building on the success of the annual Fitness Challenge, Pac 12 Recreation
        Departments are collaborating each year to create a series of events and challenges to
        inspire and engage individuals to be active and healthy. These annual events are
        designed to help our campuses build healthy communities.
    </p><br /><br />
    <p>
        Help your school secure the title of the conference’s most active school by participating
        in the Pac-12 Fitness Challenge!  The Pac-12 Fitness Challenge is a conference-wide initiative
        promoting regular physical activity.  From February 24-28 all twelve schools will be competing
        to accumulate the most minutes of  activity and earn the title of
        Pac-12 Fitness Challenge Champion!
    </p>
    <p class="text-center pad">
        <a href="{{ URL::to('account') }}" class="btn btn-primary">View My Account</a>
    </p>
</div>
<div class="rule"></div>
<div class="section apps" style="margin-top:20px;">
    <div>
        <a class="apple" href="https://itunes.apple.com/us/app/preva/id633688529?mt=8" target="_blank"></a>
        <a class="droid" href="https://play.google.com/store/apps/details?id=com.preva.app" target="_blank"></a>
        <a class="linkAccount" href="https://na-api.preva.com/exerciser-api/oauth/authorize?client_id=angelvision&redirect_uri=https%3A%2F%2Fpac12challenge.org%2F&response_type=code"></a>
    </div>
</div>
<div class="rule"></div>
<div class="section s3">
    <div class="s3d"></div>
    <h1>CLICK YOUR SCHOOL'S ICON</h1>
    <div class="icons">
        <p>
            <a class="icon icon1" href="http://rec.arizona.edu/" target="_blank"></a>
            <a class="icon icon2" href="https://fitness.asu.edu/" target="_blank"></a>
            <a class="icon icon3" href="http://recsports.berkeley.edu/about/events/fitwellweek/" target="_blank"></a>
            <a class="icon icon4" href="http://uoregon.edu/sports" target="_blank"></a>
        </p>
        <p>
            <a class="icon icon5" href="http://calendar.oregonstate.edu/" target="_blank"></a>
            <a class="icon icon6" href="http://www.stanford.edu/dept/pe/cgi-bin/cardinalrec/pac-12-fitness-challenge/" target="_blank"></a>
            <a class="icon icon7" href="http://www.recreation.ucla.edu/pac12challenge" target="_blank"></a>
            <a class="icon icon8" href="http://sait.usc.edu/Recsports/calendars/sports/pac-12-fitness-challenge-week-2014" target="_blank"></a>
        </p>
        <p>
            <a class="icon icon9" href="http://www.washington.edu/ima" target="_blank"></a>
            <a class="icon icon10" href="http://www.urec.wsu.edu/events/pac-12-challenge/" target="_blank"></a>
            <a class="icon icon11" href="http://www.colorado.edu/recreation" target="_blank"></a>
            <a class="icon icon12" href="http://campusrec.utah.edu/" target="_blank"></a>
        </p>
    </div>
    <p>For Pac-12 Fitness Challenge Events On Your Campus.</p>
</div>
<div class="rule"></div>
<div class="section s5">
    <h1>WHAT'S NEW FOR 2014?</h1>
    <ol>
        <li>
            Anyone can participate!  Sign up and indicate your school - no need to have an EDU email address.
        </li>
        <li>
            Log up to 120 minutes per day for your school
        </li>
        <li>
            Download the Preva Mobile app from the App store or Google Play!
        </li>
    </ol>
    <p class="text-center" style="margin:30px 0;">
        <img src="{{ asset('assets/images/new.png') }}" />
    </p>
</div>
<div class="rule"></div>
<div class="section s6">
    <h1>WHO WILL BE THIS YEAR'S CHAMPION?</h1>
    <p>Previous Winners:</p>
    <ul>
        <li>UCLA</li>
        <li>ASU</li>
        <li>Stanford</li>
    </ul>
    <p class="text-center" style="margin:30px 0;">
        <img src="{{ asset('assets/images/champion.png') }}" />
    </p>
</div>
<div class="rule"></div>
<div class="section s7">
    <img src="{{ asset('assets/images/section-7-mobile.png') }}" width="500" />
</div>
<div id="footer">
    <p>&copy; 2007 - 2014 Pac-12 Recreation Challenge</p>
    <p>Phone: 509-335-8732</p>
    <p>This is not a Pac-12 sporting event.</p>
    <p><a href="{{ URL::to('/') }}?desktop=1">Show Desktop Site</a></p>
</div>
@stop
