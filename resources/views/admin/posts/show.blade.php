@extends('layouts.app')

@section('content')
<div class="container">

  <h1 class="mb-4">{{ $post->title }}</h1>
  <hr/>
  <div class="card mb-3">
    <div class="row no-gutters">
      <div class="col-md-4">
        <img class="img-fluid" src="{{ $post->thumb ?? 'https://media.istockphoto.com/vectors/thumbnail-image-vector-graphic-vector-id1147544807?k=20&m=1147544807&s=612x612&w=0&h=pBhz1dkwsCMq37Udtp9sfxbjaMl27JUapoyYpQm0anc=' }}" alt="{{ $post->title }}">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title">{{ $post->title }}</h5>
          <p class="card-text">{{ $post->content }}</p>
          <p class="card-text"><small class="text-muted">Creato il: {{ $post->created_at }}</small></p>
          <p class="card-text"><small class="text-muted">Ultima Modifica: {{ $post->updated_at }}</small></p>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="btn btn-secondary ml-2" href="{{ route('admin.posts.index') }}">
            <i class="fa-solid fa-arrow-rotate-left"></i> Indietro
          </a>

          <div class="d-flex">
            <a class="btn btn-warning ml-2" href="{{ route('admin.posts.edit', $post) }}">
              <i class="fa-solid fa-pen-to-square"></i> Modifica
            </a>
            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="ml-2">
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
</div>   
@endsection