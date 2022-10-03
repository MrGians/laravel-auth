@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Ti sei autenticato!') }}
                </div>
            </div>
        </div>
        <div class="col-md-8 my-3">
            <div class="card">
                <div class="card-header"> Profilo </div>

                <div class="card-body">
                    <p class="card-text d-flex">
                        <span><strong>Username: </strong>{{ $current_user->name }}</span>
                        <span class="ml-5"><strong>Email: </strong>{{ $current_user->email }}</span>
                    </p>
                </div>
                <div class="card-header border-top"> Informazioni Personali </div>
                <div class="card-body">
                <p class="card-text d-flex">
                    <span><strong>Nome: </strong>{{ $current_user->detail->first_name ?? 'N/D' }}</span>
                    <span class="ml-5"><strong>Cognome: </strong>{{ $current_user->detail->last_name ?? 'N/D' }}</span>
                    <span class="ml-5"><strong>Telefono: </strong>{{ $current_user->detail->phone ?? 'N/D' }}</span>
                </p>
            </div>
            </div>
        </div>
    </div>
@endsection
