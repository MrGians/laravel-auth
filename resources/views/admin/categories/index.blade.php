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
      <td>{{ $category->updated_at }}</td>
      <td>{{ $category->created_at }}</td>
      <td class="d-flex">
        <a class="btn btn-sm btn-primary ml-2" href="{{ route('admin.categories.show', $category) }}">
          <i class="fa-solid fa-eye"></i>
        </a>
        <a class="btn btn-sm btn-warning ml-2" href="{{ route('admin.categories.edit', $category) }}">
          <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="delete-form ml-2">
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

@endsection
