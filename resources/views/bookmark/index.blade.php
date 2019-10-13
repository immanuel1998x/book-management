@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-5">
        <div class="container">
            <div class="row">
                @if (count($bookmarks) > 0)
                @foreach ($bookmarks as $book)
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
            {{ $bookmarks->links() }}
        </div>
    </div>
</div>
@endsection