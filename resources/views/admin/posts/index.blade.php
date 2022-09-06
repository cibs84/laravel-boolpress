@extends('layouts.dashboard')

@section('content')
    {{-- Message to confirm deleted post --}}
    @if ( $post_deleted )
        <div class="alert alert-success" role="alert">
            Post eliminato con successo!
        </div>
    @endif

    <h1>Lista Post</h1>

    <div class="row row-cols-5">
        @foreach ($posts as $post)
            {{-- Single Post Card --}}
            <div class="col">
                <div class="card mb-4" style="width: 18rem;">
                    {{-- <img src="..." class="card-img-top" alt="..."> --}}
                    <div class="card-body">
                        <h3 class="card-title">{{ $post->title }}</h3> 
                        <div class="ms_module ms_fade">
                            <p class="card-text">{{ $post->content }}</p>
                        </div>
                        <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}" class="btn btn-primary">Visualizza</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection