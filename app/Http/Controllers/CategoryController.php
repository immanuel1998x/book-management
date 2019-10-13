<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->orderBy('updated_at', 'DESC')->get();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
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
            'category_name' => 'required|min:3|unique:categories,name,NULL,id,user_id,' . Auth::id() . '|max:50',
        ]);

        $category = new Category();
        $category->user_id = Auth::id();
        $category->name = ucfirst($request->input('category_name'));
        $category->save();
        return redirect('/category')->with('success', 'Category was successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $request->validate([
            'name' => 'required|min:3|unique:categories,name,NULL,id,user_id,' . Auth::id() . '|max:50',
        ]);
         
        $category = Category::find($id);
        $category->name = ucfirst($request->input('name'));
        $category->updated_at = date('Y-m-d H:i:s');

        if ($category->save()) {
            $request->session()->flash('success', 'Category was successfully updated.');
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
        $category = Category::find($id);
        $category->delete();
        return json_encode(['success' => true]);
    }

    public function fetch(Request $request) {
        $id = $request->input('id');
        $category = Category::where('id', $id)->pluck('name');
        return $category;
    }
}
