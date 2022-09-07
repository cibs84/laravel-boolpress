@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Modifica Post</h1>

        <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value='{{ old('title', $post->title) }}'>
                @error('title')
                    <div class="alert alert-danger form-text">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Categories --}}
            <div class="mb-3">
                <label for="category_id">Categoria:</label>
                <select class="form-select form-select-lg" id="category_id" name="category_id">
                    <option value=''>Nessuna</option>

                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{ old('category_id', $post->category->id) == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            {{-- Content --}}
            <div class="mb-3">
                <label for="content" class="form-label">Testo</label>
                <textarea class="form-control" id="content" cols="30" rows="10" name="content">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="alert alert-danger form-text">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection