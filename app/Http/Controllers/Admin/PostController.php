<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $categories = Category::all();

        $query = Post::orderBy('updated_at', 'DESC');
        $selected_category = $request->query('category_id');
        
        $posts = $selected_category ? $query->where('category_id', $selected_category)->paginate(15) : $query->paginate(15);
        
        return view('admin.posts.index', compact('posts', 'categories', 'selected_category'));
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
        $tags = Tag::select('id', 'label')->get();
        return view('admin.posts.create', compact('post', 'categories', 'tags'));
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
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id'
        ], [
            'title.required' => 'Il Titolo è obbligatorio',
            'title.min' => 'Il Titolo deve contenere almeno :min caratteri',
            'title.max' => 'Il Titolo deve contenere massimo :max caratteri',
            'title.unique' => "Il Titolo \"$request->title\" esiste già",
            'thumb.url' => "L'immagine deve essere un URL valido",
            'content.required' => 'Il Contenuto è obbligatorio',
            'category_id.exists' => 'La Categoria selezionata non esiste',
            'tags.exists' => 'Uno o più Tag selezionati non sono presenti nella lista'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $data['is_published'] = array_key_exists('is_published', $data);
        $data['user_id'] = Auth::id();
        $post = new Post();
        $post->fill($data);
        $post->save();

        if(array_key_exists('tags', $data)) $post->tags()->attach($data['tags']);

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
        $tags = Tag::select('id', 'label')->get();
        $post_tag_ids = $post->tags->pluck('id')->toArray();
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'post_tag_ids'));
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
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id'
        ], [
            'title.required' => 'Il Titolo è obbligatorio',
            'title.min' => 'Il Titolo deve contenere almeno :min caratteri',
            'title.max' => 'Il Titolo deve contenere massimo :max caratteri',
            'title.unique' => "Il Titolo \"$request->title\" esiste già",
            'thumb.url' => "L'immagine deve essere un URL valido",
            'content.required' => 'Il Contenuto è obbligatorio',
            'category_id.exists' => 'La Categoria selezionata non esiste',
            'tags.exists' => 'Uno o più Tag selezionati non sono presenti nella lista'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $data['is_published'] = array_key_exists('is_published', $data);
        if(isset($data['switch_author'])) $data['user_id'] = Auth::id();
        $post->update($data);

        if(!array_key_exists('tags', $data)) $post->tags()->detach();
        else $post->tags()->sync($data['tags']);
        
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
        if(count($post->tags)) $post->tags()->detach();
        $post->delete();
        
        return redirect()->route('admin.posts.index')
        ->with('message', 'Il Post è stato eliminato correttamente')->with('type', 'success');
    }

    public function destroy_all()
    {
        DB::table('posts')->delete();
        
        return redirect()->route('admin.posts.index')
        ->with('message', 'Tutti i Post sono stati eliminati correttamente')->with('type', 'success');
    }

    /**
     * Toggle is_published column from posts table.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function toggle(Post $post)
    {
        $post->is_published = !$post->is_published;
        $post->save();

        $status = $post->is_published ? 'Pubblicato' : 'Rimosso';
        
        return redirect()->route('admin.posts.index')
        ->with('message', "Post \"$post->title\" $status correttamente")->with('type', 'success');
    }
}
