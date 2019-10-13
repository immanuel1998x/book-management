@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center developer">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset('images/developer/profile.jpg') }}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-center">{{ config('string.author') }}</h5>
                    <p class="text-center">{{ config('string.position') }}</p>
                    <hr>
                    <div class="text-center">
                        <a class="btn btn-success" href="{{ url(config('url.developer.site')) }}" target="_blank"><i
                                class="fas fa-link"></i></a>
                        <a class="btn btn-primary" href="{{ url(config('url.developer.facebook')) }}" target="_blank"><i
                                class="fab fa-facebook-f"></i></a>
                        <button type="button" class="btn btn-danger" id="gmailAccount"><i
                                class="fab fa-google-plus"></i></button>
                        <a class="btn btn-primary" href="{{ url(config('url.developer.linkedin')) }}"
                            target="_blank"><i class="fab fa-linkedin"></i></a>
                        <a class="btn btn-primary" href="{{ url(config('url.developer.github')) }}" target="_blank"><i
                                class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection