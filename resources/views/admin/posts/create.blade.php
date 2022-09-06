@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Crea un nuovo Post</h1>

        <form action="{{ route('admin.posts.store') }}" method="post">
            @csrf
            
            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value='{{ old('title') }}'>
                @error('title')
                    <div class="alert alert-danger form-text">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Content --}}
            <div class="mb-3">
                <label for="content" class="form-label">Testo</label>
                <textarea class="form-control" id="content" cols="30" rows="10" name="content">{{ old('content') }}</textarea>
                @error('content')
                    <div class="alert alert-danger form-text">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
    </div>
@endsection