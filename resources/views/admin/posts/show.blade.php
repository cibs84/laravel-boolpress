@extends('layouts.dashboard')

@section('content')
    {{-- Messages for created/updated post --}}
    @if ( $post_created )
        <div class="alert alert-success" role="alert">
            Post inserito con successo!
        </div>
    @elseif ( $post_updated )
        <div class="alert alert-success" role="alert">
            Post modificato con successo!
        </div>
    @endif

    {{-- Title --}}
    <h1>{{ $post->title }}</h1>

    {{-- Meta Data --}}
    <div class="meta-data my-4">
        <h5><strong>Creato il:</strong> {{ $post->created_at->format('l, j F Y') }} - {{ $how_long_ago }}</h5>
        <h5><strong>Aggiornato il:</strong> {{ $post->updated_at->format('l, j F Y') }} - {{ $how_long_ago }}</h5>
        <h5><strong>Slug:</strong> {{ $post->slug }}</h5>
        <h5><strong>Categoria:</strong> {{ $post->category ? $post->category->name : 'Nessuna' }}</h5>
        <h5>
            <strong>Tags:</strong> 
            @if ($post->tags->isNotEmpty()) 
                @foreach ($post->tags as $tag)
                    {{ $tag->name }}{{$loop->last ? '' : ','}}
                @endforeach
            @else
                Nessuno
            @endif
        </h5>
    </div>

    {{-- Content --}}
    <p class="post-content">{{ $post->content }}</p>

    {{-- Modify --}}
    <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Modifica</a>
    {{-- Delete --}}
    <form class="form-btn-elimina" action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('DELETE')

        <input type="submit" value="Elimina" class="btn btn-danger" onClick="return confirm('Sei sicuro di voler eliminare il post?');">
    </form>
@endsection