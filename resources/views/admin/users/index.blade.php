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
      <td>{{ $user->detail->first_name ?? 'N/D' }}</td>
      <td>{{ $user->detail->last_name ?? 'N/D' }}</td>
      <td>{{ $user->detail->phone ?? 'N/D' }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ count($user->posts) }}</td>
      <td>{{ $user->updated_at }}</td>
      <td>{{ $user->created_at }}</td>
    </tr>
    @empty
    <tr>
      <th class="text-center h2" colspan="8">Non è presente nessun Utente.</th>
    </tr>
    @endforelse
  </tbody>
</table>
{{-- Pagination --}}
@if($users->hasPages())
  {{ $users->links() }}
@endif

@endsection
