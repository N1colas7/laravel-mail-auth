@extends('layouts.admin')
@section('content')
<div class="contaier">
    <div class="row">
        <div class="col-12 my-5">
            <h2>Aggiungi Nuovo Progetto</h2>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-12">
            <form action="{{ route('admin.posts.update', $post->slug)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="control-label">
                        Titolo
                    </label>
                    <input type="text" class="form-control" placeholder="Titolo" id="title" name="title" value="{{ old('title') ?? $post->title }}">
                    @error('title')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group my-3">
                    <label class="control-label">Copertina</label>
                        <div class="mb-3">
                            <img src="{{ asset('/storage/' .$post->cover_image) }}" class="w-50">
                        </div>
                            <input type="file" name="cover_image" id="cover_image" class="form-control @error('cover_image')is-invalid @enderror">
                        @error('cover_image')
                            <div class="text-danger">
                                {{ message }}
                            </div>
                        @enderror
                </div>
                <div class="form-group mt-3">
                    <div class="control-label">Tecnologie</div>
                    @foreach ($technology as $tech)
                    <div class="form-check @error('technology') is invalid @enderror">
                        {{-- primo caso: in caso di errore di validazione bisogna ricaricaricare le tecnologie con old --}}
                        @if ($errors->any())
                        <input class="form-check-input" type="checkbox" value="{{ $tech->id }}" name="technologies[]" {{ in_array($tech->id, old('techonology, []')) ? 'checked' : '' }} >
                        <label class="form-check-label">{{ $tech->name }}</label>
                        @else
                        {{-- secondo caso:se ci sono problemi di validazione significa che la pagina è stata aperta per la prima volta--}}
                        <input class="form-check-input" type="checkbox" value="{{ $tech->id }}" name="technologies[]" {{ $post->technologies->contains($tech) ? 'checked' : '' }}>
                        @endif
                        <label class="form-check-label">{{ $tech->name }}</label>
                    </div>
                    @endforeach
                    @error('technology')
                    <div class="invalid-feedback">{{ message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="control-label">
                         Contenuto
                    </label>
                    <textarea class="form-control" placeholder="Contenuto" id="content" name="content">{{ old('title') ?? $post->content }}
                    </textarea>
                </div>
                <div class="form-group my-3">
                    <button type="submit" class="btn btn-success">Salva il Progetto</button>
                </div>
            </form>
        </div>    
    </div>
</div>
@endsection