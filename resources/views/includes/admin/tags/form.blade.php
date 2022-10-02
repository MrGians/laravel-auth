@include('includes.admin.errors')

@if ($tag->exists)
<form action="{{ route('admin.tags.update', $tag) }}" method="POST" novalidate>
@method('PUT')
@else
<form action="{{ route('admin.tags.store') }}" method="POST" novalidate>
@endif

  @csrf
  <div class="row">
    {{-- Label --}}
    <div class="col-6">
      <div class="form-group">
        <label for="label">Label</label>
        <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label', $tag->label) }}" required>
      </div>
    </div>
    {{-- Color --}}
    <div class="col-6">
      <div class="form-group">
        <label for="color">Colore</label>
        <input type="color" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color', $tag->color) }}" required>
      </div>
    </div>
    
    {{-- Actions --}}
    <div class="col-12">
      <div class="form-group d-flex justify-content-between">
        <a class="btn btn-secondary ml-2" href="@if($tag->exists){{ route('admin.tags.show', $tag) }}@else{{ route('admin.tags.index') }}@endif">
          <i class="fa-solid fa-arrow-rotate-left"></i> Indietro
        </a>
        <button class="btn btn-success btn-outline" type="submit">
          <i class="fa-solid fa-floppy-disk"></i> Salva
        </button>
      </div>
    </div>
  </div>
</form>