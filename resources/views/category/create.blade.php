@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Add Category</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('category.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="category">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name"
                                value="{{ old('category_name') }}" placeholder="Comic and Graphic Novel" required autofocus>

                            @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection