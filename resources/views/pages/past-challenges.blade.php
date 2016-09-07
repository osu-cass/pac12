@extends('template')

@section('title', 'Fitness Challenge')

@section('css')
{{ HTML::style('assets/css/pages/welcome.css?v=' . VERSION) }}
{{ HTML::style('assets/css/pages/past-challenges.css?v=' . VERSION) }}
@stop

@section('js')
@stop

@section('header')
@include('header')
@stop

@section('content')
<div class="colwrapper">
    <div class="row">
        <div class="col-sm-12">
            {{ $page->html }}
        </div>
    </div>
</div>
<div class="colwrapper">
    @foreach ($challenges as $challenge)
    <div class="challenge row">
        <div class="challengeText col-sm-6 col-xs-12">
            <h2>{{ $challenge->name }}</h2>
            <p>{{ $challenge->description }}</p>
        </div>
        <div class="challengeImages col-sm-6 col-xs-12">
            @foreach (Image::where('challenge_id', '=', $challenge->id)->get() as $image)
            <div class="col-xs-3">
                <a href="{{ $image->url() }}" target="_blank">
                    <img src="{{ $image->url() }}" style="width:100%;" />
                </a>
            </div>
            @endforeach
        </div>
        <img src="{{ asset('assets/images/section-3.png') }}" alt="" class="section-divider">

</div>
    @endforeach
</div>

@stop

@section('footer')
@include('footer')
@stop