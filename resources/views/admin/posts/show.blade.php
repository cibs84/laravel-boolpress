@extends('layouts.dashboard')

@section('content')
    {{-- Messages for created/updated post --}}
    @if ( $post_created )
        <div class="alert alert-success" role="alert">
            Post inserito con successo!
        </div>
        {{-- @elseif ( $post_updated )
        <div class="alert alert-success" role="alert">
            Post modificato con successo!
        </div> --}}
    @endif
    {{-- Title --}}
    <h1>{{ $post->title }}</h1>

    {{-- Meta Data --}}
    <div class="meta-data my-4">
        <h5><strong>Creato il:</strong> {{ $post->created_at }}</h5>
        <h5><strong>Aggiornato il:</strong> {{ $post->updated_at }}</h5>
        <h5><strong>Slug:</strong> {{ $post->slug }}</h5>
    </div>

    {{-- Content --}}
    <p class="post-content">{{ $post->content }}</p>
@endsection