<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('updated_at', 'DESC')
        ->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        return view('admin.categories.create', compact('category'));
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
            'label' => 'required|string|min:1|max:20|unique:categories',
            'color' => 'nullable|string',
        ], [
            'label.required' => 'Il Label è obbligatorio',
            'label.min' => 'Il Label deve contenere almeno :min caratteri',
            'label.max' => 'Il Label deve contenere massimo :max caratteri',
            'label.unique' => "Il label \"$request->label\" esiste già",
            'color.string' => 'Il Colore deve essere una stringa',
        ]);

        $data = $request->all();
        $category = new Category();
        $category->fill($data);
        $category->save();

        return redirect()->route('admin.categories.show', compact('category'))
        ->with('message', 'La Categoria è stata creata correttamente')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'label' => ['required','string','min:1','max:20', Rule::unique('categories')->ignore($category->id)],
            'color' => 'nullable|string',
        ], [
            'label.required' => 'Il Label è obbligatorio',
            'label.min' => 'Il Label deve contenere almeno :min caratteri',
            'label.max' => 'Il Label deve contenere massimo :max caratteri',
            'label.unique' => "Il label \"$request->label\" esiste già",
            'color.string' => 'Il Colore deve essere una stringa',
        ]);

        $data = $request->all();
        $category->update($data);

        return redirect()->route('admin.categories.show', compact('category'))
        ->with('message', 'La Categoria è stata modificata correttamente')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        
        return redirect()->route('admin.categories.index')
        ->with('message', 'La Categoria è stata eliminata correttamente')->with('type', 'success');
    }
}
