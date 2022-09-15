@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Modifica Post</h1>

        <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data">
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
                        <option value="{{$category->id}}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tags --}}
            <div class="mb-4">
                <h3>Tags</h3>
                @foreach ($tags as $tag)
                <div class="form-check form-check-inline">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="tag-{{ $tag->id }}" 
                        value="{{ $tag->id }}" 
                        name="tags[]"
                        @if (old('tags'))
                            {{in_array($tag->id, old('tags')) ? 'checked' : ''}}
                        @else
                            {{$post->tags->contains($tag) ? 'checked' : ''}}
                        @endif
                        >
                        
                    <label class="form-check-label" for="tag-{{ $tag->id }}">{{ old('tag', $tag->name) }}</label>
                </div>
                @endforeach
            </div>

            {{-- Image --}}
            <div class="mb-4">
                <label for="post-cover" class="form-label">Immagine</label>
                <input class="form-control" type="file" name="post-cover" id="post-cover">
                @error('post-cover')
                    <div class="alert alert-danger form-text">{{ $message }}</div>
                @enderror
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