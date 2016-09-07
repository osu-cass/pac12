@extends('template')

@section('title', 'Fitness Challenge')

@section('css')
    {{ HTML::style('assets/css/pages/sponsors.css?v=' . VERSION) }}
@stop

@section('js')
@stop

@section('header')
    @include('header')
@stop

@section('content')
    <div class="colwrapper sponsors">
        {{ $page->html }}
        <ul class="list-sponsors">
        @foreach (Sponsor::all() as $sponsor)
            @if($sponsor->is_published())
            <li>
                @if ($sponsor->url)
                    <a href="{{ $sponsor->url }}" target="_blank">
                @endif

                <h3 class="sponsor-title">{{ $sponsor->name }}</h3>
                @if ($sponsor->banner)
                    <img class="sponsor-banner" src='{{ asset($sponsor->banner) }}' alt=''>
                @elseif($sponsor->video)
                    {{ $sponsor->video }}
                @endif

                @if ($sponsor->url)
                    </a>
                @endif
            </li>
            @endif
        @endforeach
        </ul>
    </div>
@stop

@section('footer')
    @include('footer')
@stop