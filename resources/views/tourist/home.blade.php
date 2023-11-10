@extends('tourist.index')

@section('home')

<div class="row" style="width: 100vw; height: 100vh;">
    {{-- Left Section --}}
    <div class="col-lg d-flex flex-column justify-content-center align-items-center">
        <h1 class="landing-heading-title">
            BOOK YOUR TRIPS<br />WITH US
        </h1>

        <div class="wrapper">
            <div class="item">
                <div class="polaroid">
                    <img src="{{ asset('assets/images/presets/preset-3.jpg') }}">
                    <div class="caption">&nbsp;</div>
                </div>
            </div>

            <div class="item">
                <div class="polaroid">
                    <img src="{{ asset('assets/images/presets/preset-2.jpg') }}">
                    <div class="caption">&nbsp;</div>
                </div>
            </div>

            <div class="item">
                <div class="polaroid">
                    <img src="{{ asset('assets/images/presets/preset-1.jpg') }}">
                    <div class="caption">&nbsp;</div>
                </div>
            </div>
        </div>

        <h1 class="landing-heading-title" style="color: #9FC669; transform: scale(1) translateY(-40px);">
            RESERVE NOW!!
        </h1>

        @if(!Auth::guard('tourist')->check())
            <a href="{{ route('tourist.login') }}" class="btn btn-warning btn-lg rounded-pill px-5" style="transform: scale(1) translateY(-50px); font-weight: bold; color: white;">BOOK NOW</a>
        @else
            <a href="{{ route('tourist.reservation') }}" class="btn btn-warning btn-lg rounded-pill px-5" style="transform: scale(1) translateY(-50px); font-weight: bold; color: white;">BOOK NOW</a>
        @endif
    </div>

    {{-- Right Section --}}
    <div class="col-lg d-flex flex-column justify-content-center align-items-center" style="position: relative;">
        <img class="img-fluid" src="{{ asset('assets/images/presets/preset-1.jpg') }}" width="800px" height="auto" style="cursor: pointer;">
        <img class="img-fluid" src="{{ asset('assets/images/presets/play-button-template.png') }}" width="100px" height="auto" style="position: absolute; cursor: pointer;">
    </div>
</div>

@endsection
