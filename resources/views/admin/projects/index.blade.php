@extends('layouts.app')

@section('content')
  <div class="container">
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
        @forelse($projects as $project)
          <tr>
            <th scope="row">{{ $project->id }}</th>
            <td>{{ $project->name }}</td>
            <td>{{ $project->description }}</td>
            <td>{{ $project->link }}</td>
            {{-- # CI CREIAMO UN PULSANTE CHE CI PORTA AL DETTAGLIO DEL PROJECT --}}
            <td> <a href="{{ route('admin.projects.show', $project) }}">Show</a></td>
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
