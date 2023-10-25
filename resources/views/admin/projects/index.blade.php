@extends('layouts.app')

{{-- # METTIAMO LA CDN DI FONTAWESOME PER LE ICONE --}}
@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
  <div class="container">
    {{-- # CI CREIAMO UN PULSANTE CHE CI PORTA AL FORM PER CREARE UN NUOVO PROJECT --}}
    <a href="{{ route('admin.projects.create') }}" class="btn btn-success my-4">Crea proggetto</a>

    {{-- # CI CREIAMO UNA TABELLA CHE CONTIENE LA LISTA DEI VARI ELEMENTI DEL DB --}}
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nome</th>
          <th scope="col">Descrizione</th>
          <th scope="col">Link</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        {{-- # FACCIO UN CICLO E STAMPO UNA RIGA PER OGNI ELEMENTO DEL DB --}}
        @forelse($projects as $project)
          <tr>
            <th scope="row">{{ $project->id }}</th>
            <td>{{ $project->name }}</td>
            <td>{{ $project->description }}</td>
            <td>{{ $project->link }}</td>
            {{-- # CI CREIAMO UN PULSANTE CHE CI PORTA AL DETTAGLIO DEL PROJECT --}}
            <td> <a href="{{ route('admin.projects.show', $project) }}"><i class="fa-solid fa-eye"></i></a></td>
          </tr>
        @empty
          <tr>
            <td colspan="5">Non ci sono progetti</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    {{ $projects->links('pagination::bootstrap-5') }}
  </div>
@endsection
