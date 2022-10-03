@extends('layouts.app')

@section('content')
  <div class="mb-4 d-flex align-items-center justify-content-between">
    <h1>Lista Categorie</h1>
    <a class="btn btn-sm btn-success ml-2" href="{{ route('admin.categories.create') }}">
      <i class="fa-solid fa-plus"></i> Crea nuova categoria
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
    @forelse ($categories as $category)
    <tr>
      <th scope="row">{{ $category->id }}</th>
      <td>{{ $category->label }}</td>
      <td>
          <span class="badge badge-{{ $category->color}}">
            {{ $category->color}}
          </span>            
      </td>
      <td>{{ count($category->posts) }}</td>
      <td>{{ $category->updated_at }}</td>
      <td>{{ $category->created_at }}</td>
      <td class="d-flex">
        <a class="btn btn-sm btn-primary ml-2" href="{{ route('admin.categories.show', $category) }}">
          <i class="fa-solid fa-eye"></i>
        </a>
        <a class="btn btn-sm btn-warning ml-2" href="{{ route('admin.categories.edit', $category) }}">
          <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="delete-form delete-category ml-2">
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
      <th class="text-center h2" colspan="6">Non è presente nessuna Categoria.</th>
    </tr>
    @endforelse
  </tbody>
</table>
{{-- Pagination --}}
@if($categories->hasPages())
  {{ $categories->links() }}
@endif

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
