@extends('layouts.app')

@section('content')
  <div class="card mb-3">
    <div class="row no-gutters">
      <div class="col-md-4">
        <img class="img-fluid" src="{{ $category->thumb ?? 'https://media.istockphoto.com/vectors/thumbnail-image-vector-graphic-vector-id1147544807?k=20&m=1147544807&s=612x612&w=0&h=pBhz1dkwsCMq37Udtp9sfxbjaMl27JUapoyYpQm0anc=' }}" alt="{{ $category->label }}">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h3 class="card-title">Categoria: {{ $category->label }} | #{{ $category->id }}</h3>
          <p class="card-text">Colore: <span class="badge badge-{{ $category->color }}">{{ $category->color }}</span></p>
          <p class="card-text"><small class="text-muted">Creata il: {{ $category->created_at }}</small></p>
          <p class="card-text"><small class="text-muted">Ultima Modifica: {{ $category->updated_at }}</small></p>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="btn btn-secondary ml-2" href="{{ route('admin.categories.index') }}">
            <i class="fa-solid fa-arrow-rotate-left"></i> Indietro
          </a>

          <div class="d-flex">
            <a class="btn btn-warning ml-2" href="{{ route('admin.categories.edit', $category) }}">
              <i class="fa-solid fa-pen-to-square"></i> Modifica
            </a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="delete-form delete-category ml-2">
              @method('DELETE')
              @csrf
              <button class="btn btn-danger btn-outline" type="submit">
                <i class="fa-solid fa-trash-can"></i> Elimina
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection