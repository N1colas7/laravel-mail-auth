@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 m-3">
                <div class="d-flex justify-content-between">
                    <p><strong>Informazioni Progetto :</strong> {{$post->title}}</p>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">Torna all'elenco</a>
                </div>
            </div>
            <div class="col-12 m-3">
                 <img src="{{ asset('/storage/' .$post->cover_image ) }}" alt="{{ $post->title }}" class="w-50">   
                 <p><strong>Slug:</strong>{{$post->slug}}</p>
                 <p><strong>Tipo:</strong>{{ $post->type ? $post->type->name : 'Senza Tipologia'}}</p>
                 <p><strong>Tecnologie:</strong>
                    @forelse ($post->technologies as $tech)
                        {{ $tech->name}}
                        @empty
                            Nessuna Tecnologia   
                    @endforelse
                </p>
                 <label class="d-block"><strong>Contenuto:</strong></label>
                 <p>{{$post->content}}</p>
            </div>
        </div>
    </div>
@endsection