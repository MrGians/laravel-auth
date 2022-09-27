@extends('layouts.app')

@section('content')
    <div class="container">
      <h1 class="mb-4">Crea Nuovo Post</h1>
      <hr/>
      @include('includes.admin.posts.form')
    </div>
@endsection