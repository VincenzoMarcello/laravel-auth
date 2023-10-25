@extends('layouts.app')

@section('content')
  <div class="container mt-4">
    {{-- # PULSANTE CHE CI RIPORTA ALLA LISTA QUINDI ALL'index --}}
    <a href="{{ route('admin.projects.index') }}" class="btn btn-success">Torna alla lista</a>
    <hr>
    <form action="{{ route('admin.projects.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-12">
          <label for="name" class="form-label">Name</label>
          <input class="form-control" type="text" id="name" name="name">
        </div>

        <div class="col-12">
          <label for="link" class="form-label">Link</label>
          <input class="form-control" type="url" id="link" name="link">
        </div>

        <div class="col-12">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description">
          </textarea>
        </div>
      </div>

      {{-- ! RICORDA CHE IL BUTTON DELL'INVIO DEL FORM NON DEVE ESSERE MAI TYPE BUTTON --}}
      <button class="btn btn-success mt-3">Salva progetto</button>
    </form>
  @endsection
