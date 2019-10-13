<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::where('user_id', Auth::id())->where('owned', true)->orderBy('updated_at', 'DESC')->paginate(8);
        if (count($books) > 0) {
            $categories = Category::select('id', 'user_id', 'name')->where('user_id', Auth::id())->orderBy('name', 'ASC')->get();
            
            $data = [
                'categories' => $categories,
                'books' => $books
            ];

            return view('book.index')->with($data);
        } else {
            return redirect('/book/create')->with('error', 'Please add some book.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id', 'user_id', 'name')
            ->where('user_id', Auth::id())->orderBy('name', 'ASC')->get();

        return view('book.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required|min:6|max:100',
            'author' => 'required|min:3|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif,|max:2048'
        ]);

        $imageFile = 'default.jpeg';

        if ($request->image !== null) {
            $imageFile = $request->image->getClientOriginalName();
        }

        $image = uploadImage($request, $imageFile);

        $book = new Book();
        $book->user_id = Auth::id();
        $book->category_id = $request->input('category');
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->description = $request->input('description');
        $book->image = $image;
        $book->save();

        return redirect('/book')->with('success', 'Book  was successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        if ($book->user_id === Auth::id() && $book->owned) {
            $data = array(
                'id' => $book->id,
                'category' => getCategoryName($book->category_id),
                'title' => $book->title,
                'author' => $book->author,
                'description' => $book->description,
                'image' => $book->image,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at
            );

            return view('book.show')->with($data);
        } else {
            return redirect('/book/create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->input('key') === 'updateBookInfo') {
            $request->validate([
                'category' => 'required',
                'title' => 'required|min:6|max:100',
                'author' => 'required|min:3|max:100',
            ]);

            $book = Book::find($id);
            $book->category_id = $request->input('category');
            $book->title = $request->input('title');
            $book->author = $request->input('author');
            $book->description = $request->input('description');
            $book->updated_at = date('Y-m-d H:i:s');
            $book->save();

            $request->session()->flash('success', 'Book was successfully updated.');
            return json_encode(['success' => true]);
        }

        if ($request->input('key') === 'updateImage') {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,|max:2048'
            ]);

            $imageFile = $request->image->getClientOriginalName();
            $image = uploadImage($request, $imageFile);

            $book = Book::find($id);
            removeImage($book->image);
            $book->image = $image;
            $book->save();

            $request->session()->flash('success', 'Book image was successfully updated.');
            return json_encode(['success' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        return json_encode(['success' => true]);
    }

    public function fetch(Request $request) {
        $id = $request->input('id');
        $book = Book::where('id', $id)->get();
        return $book;
    }
}
