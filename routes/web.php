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

Auth::routes();
Route::get('/', function() {
    return view('home');
})->name('home');
Route::resource('category', 'CategoryController')->middleware('auth');
Route::post('/category/fetch', 'CategoryController@fetch')->name('category.fetch')->middleware('auth');
Route::resource('book', 'BookController')->middleware('auth');
Route::post('/book/fetch', 'BookController@fetch')->name('book.fetch')->middleware('auth');
Route::resource('bookmark', 'BookmarkController')->middleware('auth');
Route::get('/developer', function() {
    return view('developer');
})->name('developer')->middleware('auth');