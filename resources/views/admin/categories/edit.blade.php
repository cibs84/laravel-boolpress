@extends('layouts.dashboard')

@section('content')
    {{-- Heading --}}
    <div class="heading-container">
        <h1>Modifica categoria</h1>
        {{-- Buttons: View All / Delete --}}
        <div class="buttons-group">
            <a href="{{route('admin.categories.index')}}" class="btn btn-primary">Lista categorie</a>
            <form class="form-delete" action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" class="btn btn-danger ml-2" value="Cancella" onClick="return confirm('Sei sicuro di voler eliminare il post?');">
            </form>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{route('admin.categories.update', ['category' => $category->id])}}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="category-name" class="form-label">Nome categoria</label>
                <input type="text" 
                    class="form-control" 
                    id="category-name" 
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    >
            
            {{-- Error Message --}}
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        {{-- Button --}}
        <button type="submit" class="btn btn-primary">Salva</button>
    </form>
@endsection