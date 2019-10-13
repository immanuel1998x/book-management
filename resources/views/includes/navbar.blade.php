<li class="nav-item">
    <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle {{ (request()->is('category*')) ? 'active' : '' }}" data-toggle="dropdown" href="#" id="category"><i class="fas fa-list-alt"></i>
        Category
        <span class="caret"></span></a>
    <div class="dropdown-menu" aria-labelledby="category">
        <a class="dropdown-item" href="{{ route('category.create') }}">Add
            Category</a>
        <a class="dropdown-item" href="{{ route('category.index') }}">Manage
            Categories</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle {{ (request()->is('book*')) ? 'active' : '' }}" data-toggle="dropdown" href="#" id="book"><i class="fas fa-book"></i> Book
        <span class="caret"></span></a>
    <div class="dropdown-menu" aria-labelledby="book">
        <a class="dropdown-item" href="{{ route('book.create') }}">Add Book</a>
        <a class="dropdown-item" href="{{ route('book.index') }}">Manage Books</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle {{ (request()->is('bookmark*')) ? 'active' : '' }} " data-toggle="dropdown" href="#" id="bookmark"><i class="fas fa-bookmark"></i>
        Bookmark
        <span class="caret"></span></a>
    <div class="dropdown-menu" aria-labelledby="bookmark">
        <a class="dropdown-item" href="{{ route('bookmark.create') }}">Add Bookmark</a>
        <a class="dropdown-item" href="{{ route('bookmark.index') }}">Manage Bookmarks</a>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link {{ (request()->is('developer')) ? 'active' : '' }}" href="{{ route('developer') }}"><i class="fas fa-code"></i> Developer</a>
</li>