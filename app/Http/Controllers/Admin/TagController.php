<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Validation\Rule;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('updated_at', 'DESC')
        ->paginate(15);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tag = new Tag();
        return view('admin.tags.create', compact('tag'));
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
            'label' => 'required|string|min:1|max:10|unique:tags',
            'color' => 'required|string|min:7|max:7',
        ], [
            'label.required' => 'Il Label è obbligatorio',
            'label.min' => 'Il Label deve contenere almeno :min caratteri',
            'label.max' => 'Il Label deve contenere massimo :max caratteri',
            'label.unique' => "Il label \"$request->label\" esiste già",
            'color.required' => 'Il Colore è obbligatorio',
            'color.string' => 'Il Colore deve essere una stringa',
            'color.min' => 'Il Colore deve essere un Esadecimale => #ff0000 [:min caratteri]',
            'color.max' => 'Il Colore deve essere un Esadecimale => #ff0000 [:max caratteri]',
        ]);

        $data = $request->all();
        $tag = new Tag();
        $tag->label = $data['label'];
        $tag->color = $data['color'];
        $tag->save();

        return redirect()->route('admin.tags.show', compact('tag'))
        ->with('message', 'Il Tag è stato creato correttamente')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'label' => ['required','string','min:1','max:20', Rule::unique('tags')->ignore($tag->id)],
            'color' => 'required|string|min:7|max:7',
        ], [
            'label.required' => 'Il Label è obbligatorio',
            'label.min' => 'Il Label deve contenere almeno :min caratteri',
            'label.max' => 'Il Label deve contenere massimo :max caratteri',
            'label.unique' => "Il label \"$request->label\" esiste già",
            'color.required' => 'Il Colore è obbligatorio',
            'color.string' => 'Il Colore deve essere una stringa',
            'color.min' => 'Il Colore deve essere un Esadecimale => #ff0000 [:min caratteri]',
            'color.max' => 'Il Colore deve essere un Esadecimale => #ff0000 [:max caratteri]',
        ]);

        $data = $request->all();
        $tag->label = $data['label'];
        $tag->color = $data['color'];
        $tag->save();

        return redirect()->route('admin.tags.show', compact('tag'))
        ->with('message', 'Il Tag è stato modificato correttamente')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        
        return redirect()->route('admin.tags.index')
        ->with('message', 'Il Tag è stato eliminato correttamente')->with('type', 'success');
    }
}
