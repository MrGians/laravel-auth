@extends('layouts.app')

@section('content')
  <div class="mb-4 d-flex align-items-center justify-content-between">
    <h1>Lista Tag</h1>
    <a class="btn btn-sm btn-success ml-2" href="{{ route('admin.tags.create') }}">
      <i class="fa-solid fa-plus"></i> Crea Nuovo Tag
    </a>
  </div>
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Label</th>
      <th scope="col">Color</th>
      <th scope="col">N. Post</th>
      <th scope="col">Ultima Modifica</th>
      <th scope="col">Data Creazione</th>
      <th scope="col">Azioni</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($tags as $tag)
    <tr>
      <th scope="row">{{ $tag->id }}</th>
      <td>{{ $tag->label }}</td>
      <td>
          <span class="badge badge-pill text-white" style="background-color: {{ $tag->color }}">
            {{ $tag->color}}
          </span>            
      </td>
      <td>{{ count($tag->posts) }}</td>
      <td>{{ $tag->updated_at }}</td>
      <td>{{ $tag->created_at }}</td>
      <td class="d-flex">
        <a class="btn btn-sm btn-primary ml-2" href="{{ route('admin.tags.show', $tag) }}">
          <i class="fa-solid fa-eye"></i>
        </a>
        <a class="btn btn-sm btn-warning ml-2" href="{{ route('admin.tags.edit', $tag) }}">
          <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="delete-form delete-tag ml-2">
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
      <th class="text-center h2" colspan="6">Non è presente nessun Tag.</th>
    </tr>
    @endforelse
  </tbody>
</table>
{{-- Pagination --}}
@if($tags->hasPages())
  {{ $tags->links() }}
@endif

{{-- Post List per Tag --}}
<h2 class="my-3 text-center">Elenco Post per Categoria</h2>

<div id="accordion">
  @foreach ($tags as $tag)
  <div class="card">
    {{-- Accordion Head --}}
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn text-white" style="background-color: {{ $tag->color }}" data-toggle="collapse" data-target="#{{ $tag->label }}" aria-expanded="true" aria-controls="{{ $tag->label }}">
          {{ $tag->label }} [{{ count($tag->posts) }}]
        </button>
      </h5>
    </div>
    {{-- Accordion Content --}}
    <div id="{{ $tag->label }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        <ul>
          @forelse ($tag->posts as $tag_post)
            <li><a href="{{ route('admin.posts.show', $tag_post) }}">{{ $tag_post->title }}</a></li>
          @empty
            <li>Nessun Post associato a questo Tag</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>

  @endforeach
</div>

@endsection
