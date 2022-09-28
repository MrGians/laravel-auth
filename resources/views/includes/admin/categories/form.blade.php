@include('includes.admin.errors')

@if ($category->exists)
<form action="{{ route('admin.categories.update', $category) }}" method="POST" novalidate>
@method('PUT')
@else
<form action="{{ route('admin.categories.store') }}" method="POST" novalidate>
@endif

  @csrf
  <div class="row">
    {{-- Label --}}
    <div class="col-6">
      <div class="form-group">
        <label for="label">Label</label>
        <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label', $category->label) }}" required>
      </div>
    </div>
    {{-- Color --}}
    <div class="col-6">
      <div class="form-group">
        <label for="color">Colore</label>
        <select class="form-control @error('color') is-invalid @enderror" id="color" name="color">
        @foreach (config('data.colors') as $color)
            <option @if(old('color', $category->color) === $color['value']) selected @endif value="{{ $color['value'] }}">{{ $color['color_name'] }}</option>
        @endforeach
        </select>
      </div>
    </div>
    
    {{-- Actions --}}
    <div class="col-12">
      <div class="form-group d-flex justify-content-between">
        <a class="btn btn-secondary ml-2" href="@if($category->exists){{ route('admin.categories.show', $category) }}@else{{ route('admin.categories.index') }}@endif">
          <i class="fa-solid fa-arrow-rotate-left"></i> Indietro
        </a>
        <button class="btn btn-success btn-outline" type="submit">
          <i class="fa-solid fa-floppy-disk"></i> Salva
        </button>
      </div>
    </div>
  </div>
</form>