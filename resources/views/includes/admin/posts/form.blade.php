@include('includes.admin.errors')

@if ($post->exists)
<form action="{{ route('admin.posts.update', $post) }}" method="POST" novalidate>
@method('PUT')
@else
<form action="{{ route('admin.posts.store') }}" method="POST" novalidate>
@endif

  @csrf
  <div class="row">
    {{-- Title --}}
    <div class="col-9">
      <div class="form-group">
        <label for="title">Titolo</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
      </div>
    </div>
    {{-- Caategory --}}
    <div class="col-3">
      <div class="form-group">
        <label for="category_id">Categoria</label>
        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
        <option value="">Nessuna Categoria</option>
        @foreach ($categories as $category)
            <option @if(old('category_id', $post->category_id) == $category->id) selected @endif value="{{ $category->id }}">{{ $category->label }}</option>
        @endforeach
        </select>
      </div>
    </div>
    {{-- Thumbnail --}}
    <div class="col-10 d-flex align-items-center">
      <div class="form-group w-100">
        <label for="thumb">Immagine</label>
        <input type="url" class="form-control @error('thumb') is-invalid @enderror" id="thumb" name="thumb" value="{{ old('thumb', $post->thumb) }}">
      </div>
    </div>
    {{-- Thumb Preview --}}
    <div class="col-2">
      <img class="img-fluid" src="https://media.istockphoto.com/vectors/thumbnail-image-vector-graphic-vector-id1147544807?k=20&m=1147544807&s=612x612&w=0&h=pBhz1dkwsCMq37Udtp9sfxbjaMl27JUapoyYpQm0anc=" alt="Post Preview" id="thumb-preview">
    </div>
    {{-- Content --}}
    <div class="col-12">
      <div class="form-group">
        <label for="content">Contenuto</label>
        <textarea type="text" class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $post->content) }}</textarea>
      </div>
    </div>
    {{-- Tags --}}
    @if (!empty($tags))
    <div class="col-12">
      <hr/>
      <fieldset>
        <legend>Tags</legend>
        @foreach ($tags as $tag)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="tag-{{ $tag->label }}" value="{{ $tag->id }}" name="tags[]" @if(in_array($tag->id, old('tags', $post_tag_ids ?? []))) checked @endif>
          <label class="form-check-label" for="tag-{{ $tag->label }}">{{ $tag->label }}</label>
        </div>
        @endforeach
      </fieldset>
      <hr/>
    </div>
    @endif
    <div class="col-12">
      {{-- Is Published --}}
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" @if(old('is_published', $post->is_published)) checked @endif >
        <label class="form-check-label" for="is_published">Pubblica</label>
      </div>
      {{-- Switch Authors --}}
      @if ($post->exists && $post->user_id !== Auth::id())
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="switch_author" name="switch_author" value="1" @if(old('switch_author')) checked @endif >
        <label class="form-check-label" for="switch_author">Cambia Autore [Attuale: {{ $post->author->name }}]</label>
      </div>
      @endif
    </div>
    {{-- Actions --}}
    <div class="col-12">
      <hr/>
      <div class="form-group d-flex justify-content-between">
        <a class="btn btn-secondary ml-2" href="@if($post->exists){{ route('admin.posts.show', $post) }}@else{{ route('admin.posts.index') }}@endif">
          <i class="fa-solid fa-arrow-rotate-left"></i> Indietro
        </a>
        <button class="btn btn-success btn-outline" type="submit">
          <i class="fa-solid fa-floppy-disk"></i> Salva
        </button>
      </div>
    </div>
  </div>
</form>