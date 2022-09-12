@extends('layouts.dashboard')

@section('content')
    {{-- Heading --}}
    <div class="heading-container">
        <h1>Creazione nuova categoria</h1>
        <a href="{{route('admin.categories.index')}}" class="btn btn-primary">Lista categorie</a>
    </div>

    {{-- Form --}}
    <form action="{{route('admin.categories.store')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="category-name" class="form-label">Nome nuova categoria</label>
                <input type="text" 
                    class="form-control" 
                    id="category-name" 
                    name="name"
                    value="{{ $errors->get('name') ? old('name') : '' }}"
                    >
            
            {{-- Error Message --}}
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        {{-- Button --}}
        <button type="submit" class="btn btn-primary">Crea categoria</button>
      </form>
@endsection