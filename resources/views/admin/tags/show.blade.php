@extends('layouts.app')

@section('content')
  <div class="card mb-3">
    <div class="row no-gutters">
      <div class="col-md-12">
        <div class="card-body">
          <h3 class="card-title">Tag: {{ $tag->label }} | #{{ $tag->id }}</h3>
          <p class="card-text">Colore: <span class="badge badge-pill text-white" style="background-color: {{ $tag->color }}">{{ $tag->color }}</span></p>
          <p class="card-text"><small class="text-muted">Creato il: {{ $tag->created_at }}</small></p>
          <p class="card-text"><small class="text-muted">Ultima Modifica: {{ $tag->updated_at }}</small></p>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="btn btn-secondary ml-2" href="{{ route('admin.tags.index') }}">
            <i class="fa-solid fa-arrow-rotate-left"></i> Indietro
          </a>

          <div class="d-flex">
            <a class="btn btn-warning ml-2" href="{{ route('admin.tags.edit', $tag) }}">
              <i class="fa-solid fa-pen-to-square"></i> Modifica
            </a>
            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="delete-form delete-tag ml-2">
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