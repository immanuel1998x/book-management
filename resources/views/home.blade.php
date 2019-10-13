@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="bs-component">
                <div class="jumbotron">
                    <h1 class="display-3">Book Management</h1>
                    <p class="lead">Manage your books you own and books you'd like to buy.</p>
                    <hr class="my-4">
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="{{ route('book.index') }}" role="button">Add Books</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection