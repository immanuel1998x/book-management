@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row search">
        <div class="col-sm">
            <form action="{{ route('search') }}" method="post" class="input-group mb-4">
                @csrf
                <input type="hidden" name="entity" value="book">
                <input type="text" class="form-control" id="search" name="q" placeholder="Search for Book">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit" id="btnSearch">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="total-books">
        <button class="btn btn-info" id="countBooks">Total Books</button>
    </div>
    <div class="py-5">
        <div class="container">
            <div class="row">
                @if (count($books) > 0)
                @foreach ($books as $book)
                <div class="col-md-3 book{{$book->id}}">
                    <div class="card mb-3 shadow-sm">
                        <img src="{{ asset('images/uploads/' . $book->image) }}" alt="" srcset="" height="310">
                        <div class="card-body book">
                            <p class="card-text title title-{{$book->id}}"><strong>{{$book->title}}</strong></p>
                            <small class="author author-{{$book->id}}">{{$book->author}}</small>
                            <p class="card-text description description-{{$book->id}}">{{$book->description}}</p>
                            @if (getCategoryName($book->category_id) === 0)
                                <p class="card-text category category-{{$book->id}}" style="color:red">Please assign category name.</p>                            
                            @else
                                <p class="card-text category category-{{$book->id}}">{{getCategoryName($book->category_id)}}</p>                            
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <input type="hidden" name="book_id" class="book-id" value="{{$book->id}}">
                                    <a href="{{ route('book.show', ['id' => $book->id]) }}"
                                        class="btn btn-sm btn-outline-secondary view">View</a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-secondary update-book">Update</button>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-secondary delete-book">Delete</button>
                                </div>
                            </div>
                            <small class="text-muted dark">{{timeElapsedStringShortage($book->updated_at)}}</small>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            {{ $books->links() }}
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade bd-example-modal-lg" id="updateBookModal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="bookId">
                    <label for="category">{{ __('Category') }}</label>
                    <select class="form-control" name="category" id="bookCategory" value="{{ old('category') }}" autofocus>
                        @if (count($categories) > 0)
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">{{ __('Title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ old('title') }}" placeholder="Harry Potter and The Sorcerer's Stone" required
                        autofocus>

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="author">{{ __('Author') }}</label>
                    <input type="text" class="form-control @error('author') is-invalid @enderror" id="author"
                        name="author" value="{{ old('author') }}" placeholder="J. K. Rowling" required autofocus>

                    @error('author')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                        id="description" name="description" value="{{ old('description') }}"
                        placeholder="A winner of England's National Book Award, the acclaimed debut novel tells the outrageously funny, fantastic adventure story of Harry Potter."
                        autofocus></textarea>

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">{{ __('Image') }}</label>
                    <input type="file" multiple accept='image/*'
                        class="form-control @error('image') is-invalid @enderror" name="image" id="image">

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnUpdateBook">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection