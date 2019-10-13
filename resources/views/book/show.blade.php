@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center developer">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset('images/uploads/' . $image) }}" class="card-img-top">
                <div class="card-body book">
                    <h5 class="card-title text-center"><strong>{{$title}}</strong></h5>
                    <p><strong>Author: </strong>{{$author}}</p>
                    <p><strong>Category: </strong>{{$category}}</p>
                    <p><strong>Description: </strong>{{$description}}</p>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <small><strong>{{timeElapsedStringShortage($updated_at)}}</strong></small>

                        <div class="btn-group">
                            <a href="{{ URL::previous() }}" class="btn btn-sm btn-outline-secondary back">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection