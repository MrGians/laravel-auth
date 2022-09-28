<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at', 'DESC')
        ->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        $categories = Category::select('id', 'label')->get();
        return view('admin.posts.create', compact('post', 'categories'));
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
            'title' => 'required|string|min:5|max:100|unique:posts',
            'thumb' => 'nullable|url',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id'
        ], [
            'title.required' => 'Il Titolo è obbligatorio',
            'title.min' => 'Il Titolo deve contenere almeno :min caratteri',
            'title.max' => 'Il Titolo deve contenere massimo :max caratteri',
            'title.unique' => "Il Titolo \"$request->title\" esiste già",
            'thumb.url' => "L'immagine deve essere un URL valido",
            'content.required' => 'Il Contenuto è obbligatorio',
            'category_id.exists' => 'La Categoria selezionata non esiste'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $post = new Post();
        $post->fill($data);
        $post->save();

        return redirect()->route('admin.posts.show', compact('post'))
        ->with('message', 'Il Post è stato creato correttamente')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::select('id', 'label')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => ['required','string','min:5','max:100', Rule::unique('posts')->ignore($post->id)],
            'thumb' => 'nullable|url',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id'
        ], [
            'title.required' => 'Il Titolo è obbligatorio',
            'title.min' => 'Il Titolo deve contenere almeno :min caratteri',
            'title.max' => 'Il Titolo deve contenere massimo :max caratteri',
            'title.unique' => "Il Titolo \"$request->title\" esiste già",
            'thumb.url' => "L'immagine deve essere un URL valido",
            'content.required' => 'Il Contenuto è obbligatorio',
            'category_id.exists' => 'La Categoria selezionata non esiste'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $post->update($data);
        
        return view('admin.posts.show', compact('post'))
        ->with('message', 'Il Post è stato modificato correttamente')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')
        ->with('message', 'Il Post è stato eliminato correttamente')->with('type', 'success');
    }
}
