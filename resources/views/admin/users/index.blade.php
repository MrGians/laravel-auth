@extends('layouts.app')

@section('content')
  <h1 class="mb-4">Lista Utenti</h1>
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Cognome</th>
      <th scope="col">Telefono</th>
      <th scope="col">Email</th>
      <th scope="col">Num. Post</th>
      <th scope="col">Ultima Modifica</th>
      <th scope="col">Data Creazione</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($users as $user)
    <tr>
      <th scope="row">{{ $user->id }}</th>

      @if($user->detail)
      <td>{{ $user->detail->first_name }}</td>
      <td>{{ $user->detail->last_name }}</td>
      <td>{{ $user->detail->phone }}</td>
      @elseif($user->id == Auth::id())
      <td class="text-center" colspan="3">
        <a class="btn btn-sm btn-success ml-2" href="{{ route('admin.users.create') }}">
          <i class="fa-solid fa-plus"></i> Aggiungi i tuoi dettagli
        </a>
      </td>
      @else
      <td class="text-center" colspan="3"><strong>Dettagli non disponibili</strong></td>
      @endif

      <td>{{ $user->email }}</td>
      <td>{{ count($user->posts) }}</td>
      <td>{{ $user->updated_at }}</td>
      <td>{{ $user->created_at }}</td>
    </tr>
    @empty
    <tr>
      <th class="text-center h2" colspan="8">Non è presente nessuna Utente.</th>
    </tr>
    @endforelse
  </tbody>
</table>
{{-- Pagination --}}
@if($users->hasPages())
  {{ $users->links() }}
@endif

@endsection
