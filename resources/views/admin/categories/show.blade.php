@extends('layouts.dashboard')

@section('content')
    @if ($created)
        <div class="alert alert-success" role="alert">
            Categoria creata con successo!
        </div>
    @endif
    {{-- Heading --}}
    <div class="heading-container">
        <h1>Categoria</h1>
        {{-- Actions --}}
        <div class="buttons-group">
            <a href="{{route('admin.categories.index')}}" class="btn btn-primary ml-2">Lista categorie</a>
            <a href="{{route('admin.categories.edit', ['category' => $category->id])}}" class="btn btn-primary ml-2">Modifica</a>
            <a href="{{route('admin.categories.destroy', ['category' => $category->id])}}" 
               class="btn btn-danger ml-2"
               onClick="return confirm('Sei sicuro di voler eliminare il post?');">
               Cancella
            </a>
        </div>
    </div>

    <h5 class="category-name"><span>Nome:</span> {{ $category->name }}</h5>
    <h5 class="category-slug"><span>Slug:</span> {{ $category->slug }}</h5>
@endsection