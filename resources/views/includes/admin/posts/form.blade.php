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
    <div class="col-12">
      <div class="form-group">
        <label for="title">Titolo</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
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
    {{-- Actions --}}
    <div class="col-12">
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