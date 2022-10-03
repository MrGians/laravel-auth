@include('includes.admin.errors')

<form action="{{ route('admin.userdetails.update') }}" method="POST" novalidate>
  @method('PUT')
  @csrf
  <div class="row">
    {{-- First Name --}}
    <div class="col-12">
      <div class="form-group">
        <label for="first_name">Nome</label>
        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $user_details->first_name ?? "") }}" required>
      </div>
    </div>
    {{-- Last Name --}}
    <div class="col-12">
      <div class="form-group">
        <label for="last_name">Cognome</label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $user_details->last_name ?? "") }}" required>
      </div>
    </div>
    {{-- Phone --}}
    <div class="col-12">
      <div class="form-group">
        <label for="phone">Telefono</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user_details->phone ?? "") }}" required>
      </div>
    </div>
    {{-- Actions --}}
    <div class="col-12">
      <div class="form-group d-flex justify-content-between">
        <a class="btn btn-secondary ml-2" href="{{ route('admin.home') }}">
          <i class="fa-solid fa-arrow-rotate-left"></i> Indietro
        </a>
        <button class="btn btn-success btn-outline" type="submit">
          <i class="fa-solid fa-floppy-disk"></i> Salva
        </button>
      </div>
    </div>
  </div>
</form>