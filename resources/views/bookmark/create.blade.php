@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Add Book</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('bookmark.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="category">{{ __('Category') }}</label>
                            <select class="form-control" name="category" value="{{ old('category') }}" autofocus>
                                @if (count($categories) > 0)
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">{{ __('Title') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}"
                                placeholder="Harry Potter and The Sorcerer's Stone" required autofocus>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="author">{{ __('Author') }}</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author"
                                name="author" value="{{ old('author') }}" placeholder="J. K. Rowling" required
                                autofocus>

                            @error('author')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" value="{{ old('description') }}" placeholder="A winner of England's National Book Award, the acclaimed debut novel tells the outrageously funny, fantastic adventure story of Harry Potter."
                                autofocus></textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">{{ __('Image') }}</label>
                            <input type="file" multiple accept='image/*' class="form-control @error('image') is-invalid @enderror" name="image" id="image">

                            @error('image')
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