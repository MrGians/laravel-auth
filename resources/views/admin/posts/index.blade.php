@extends('layouts.app')

@section('content')
  <div class="mb-4 d-flex align-items-center justify-content-between">
    <h1>Lista Post</h1>
    <div class="d-flex justify-align-end align-items-center">
      {{-- Category Filter --}}
      <form action="" method="GET">
        <div class="input-group">
          <select class="custom-select" name="category_id">
            <option value="">Tutte le Categorie</option>
            @foreach ($categories as $category)
            <option @if($category->id == $selected_category) selected @endif value="{{ $category->id }}">{{ $category->label }}</option>
            @endforeach
          </select>
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Filtra</button>
          </div>
        </div>
      </form>
      {{-- Add New Post --}}
      <a class="btn btn-sm btn-success ml-2 flex-shrink-0" href="{{ route('admin.posts.create') }}">
        <i class="fa-solid fa-plus"></i> Crea nuovo
      </a>
      {{-- Delete All Post --}}
      <form action="{{ route('admin.posts.destroy_all') }}" method="POST"  class="delete-form delete-post delete-all">
      @csrf
      @method('DELETE')
      <button class="btn btn-sm btn-danger ml-2 flex-shrink-0" type="submit">
        <i class="fa-solid fa-plus"></i> Elimina tutto
      </button>
      </form>
    </div>
  </div>
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titolo</th>
      <th scope="col">Autore</th>
      <th scope="col">Categoria</th>
      <th scope="col">Tag</th>
      <th scope="col">Slug</th>
      <th scope="col">Stato</th>
      <th scope="col">Ultima Modifica</th>
      <th scope="col">Data Creazione</th>
      <th scope="col">Azioni</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($posts as $post)
    <tr>
      <th scope="row">{{ $post->id }}</th>
      <td>{{ $post->title }}</td>
      <td>{{ $post->author->name ?? 'Anonimo' }}</td>
      <td>
          <span class="badge badge-{{ $post->category->color ?? 'secondary'}}">
            {{ $post->category->label ?? 'Nessuna'}}
          </span>            
      </td>
      <td>
        @forelse ($post->tags as $tag)
          <span class="badge badge-pill text-white" style="background-color: {{ $tag->color }}">{{ $tag->label }}</span>
        @empty
          <span class="badge badge-pill badge-secondary text-white">N/D</span>
        @endforelse
      </td>
      <td>{{ $post->slug }}</td>
      <td class="align-middle">
        <form action="{{ route('admin.posts.toggle', $post) }}" method="POST">
          @method('PATCH')
          @csrf
          <button class="btn btn-outline">
            <i class="fa-2x fa-solid fa-toggle-{{ $post->is_published ? 'on' : 'off' }} text-{{ $post->is_published ? 'success' : 'danger' }}"></i>
          </button>
        </form>
      </td>
      <td>{{ $post->updated_at }}</td>
      <td>{{ $post->created_at }}</td>
      <td class="d-flex">
        <a class="btn btn-sm btn-primary ml-2" href="{{ route('admin.posts.show', $post) }}">
          <i class="fa-solid fa-eye"></i>
        </a>
        <a class="btn btn-sm btn-warning ml-2" href="{{ route('admin.posts.edit', $post) }}">
          <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="delete-form delete-post ml-2">
          @method('DELETE')
          @csrf
          <button class="btn btn-sm btn-danger btn-outline" type="submit">
            <i class="fa-solid fa-trash-can"></i>
          </button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <th class="text-center h2" colspan="10">Non è presente nessun Post.</th>
    </tr>
    @endforelse
  </tbody>
</table>
{{-- Pagination --}}
@if($posts->hasPages())
  {{ $posts->links() }}
@endif
<hr/>

{{-- Post List per Category --}}
<h2 class="my-3 text-center">Elenco Post per Categoria</h2>

<div id="accordion">
  @foreach ($categories as $category)
  <div class="card">
    {{-- Accordion Head --}}
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-{{ $category->color }}" data-toggle="collapse" data-target="#{{ $category->label }}" aria-expanded="true" aria-controls="{{ $category->label }}">
          {{ $category->label }} [{{ count($category->posts) }}]
        </button>
      </h5>
    </div>
    {{-- Accordion Content --}}
    <div id="{{ $category->label }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        <ul>
          @forelse ($category->posts as $category_post)
            <li><a href="{{ route('admin.posts.show', $category_post) }}">{{ $category_post->title }}</a></li>
          @empty
            <li>Nessun Post associato a questa Categoria</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>

  @endforeach
</div>
@endsection
