<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Book;
use Illuminate\Http\Request;

Auth::routes();
Route::get('/', function() {
    return view('home');
})->name('home');

// Category route
Route::resource('/category', 'CategoryController')->middleware('auth');
Route::post('/category/fetch', 'CategoryController@fetch')->name('category.fetch')->middleware('auth');

// Book route
Route::resource('/book', 'BookController')->middleware('auth');
Route::post('/book/fetch', 'BookController@fetch')->name('book.fetch')->middleware('auth');
Route::post('/book/total', 'BookController@total')->name('book.total')->middleware('auth');

Route::resource('bookmark', 'BookmarkController')->middleware('auth');
Route::get('/developer', function() {
    return view('developer');
})->name('developer')->middleware('auth');


Route::any('/search', function(Request $request) {

    $entity = $request->input('entity');
    $q = $request->q;
    
    if ($entity === 'book') {
        if ($q !== null) {
            $books = Book::where('owned', '=', true)
                ->where(function($q) use ($request) {
                    $q->where('title', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('author', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->q . '%');
                })
                ->paginate(12);
            return view('search', compact('books'));
        } else {
            return redirect('book');
        }
    } else if ($entity === 'bookmark') {
        if ($q !== '') {
            dd($q);
        } else {
            return redirect('bookmark')->with('error', 'Unable to find bookmarks');
        }
    } else {
        return redirect('book')->with('error', 'Unable to find book');
    }

    return redirect('book')->with('error', 'Unable to find book');
})->name('search')->middleware('auth');