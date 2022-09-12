@extends('layouts.dashboard')

@section('content')
    @if ($updated)
        <div class="alert alert-success" role="alert">
            Categoria modificata con successo!
        </div>
    @elseif ($deleted)
        <div class="alert alert-success" role="alert">
            Categoria eliminata con successo!
        </div>
    @endif
    {{-- Heading --}}
    <div class="heading-container">
        <h1>Lista Categorie</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Crea nuova categoria</a>
    </div>
    {{-- Table --}}
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Azioni</th>
        </tr>
        </thead>
        <tbody>
        {{-- List Categories --}}
        @foreach ($categories as $category)
            <tr>
                <th scope="row">{{ $category->id }}</th>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td class="buttons-group">
                    <a href="{{route('admin.categories.show', ['category' => $category->id])}}" class="btn btn-primary ml-2">Visualizza</a>
                    <a href="{{route('admin.categories.edit', ['category' => $category->id])}}" class="btn btn-primary ml-2">Modifica</a>
                    <form class="form-delete" action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-danger ml-2" value="Cancella" onClick="return confirm('Sei sicuro di voler eliminare il post?');">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection