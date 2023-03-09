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
            <form action="{{ route('admin.posts.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="control-label">
                        Titolo
                    </label>
                    <input type="text" class="form-control" placeholder="Titolo" id="title" name="title">
                    @error('title')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group my-3">
                    <label class="control-label">Copertina</label>
                        <input type="file" name="cover_image" id="cover_image" class="form-control @error('cover_image')is-invalid @enderror">
                        @error('cover_image')
                        <div class="text-danger">{{ message }}</div>
                        @enderror
                </div>
                <div class="form-group mt-3 ">
                    <label class="control-label">
                        Tipo
                   </label>
                   <select class="form-control" name="type_id" id="type_id">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                   </select>
                </div>
                @foreach ($technology as $tech)
                <div class="form-check @error('technology') is invalid @enderror">
                    <input class="form-check-input" type="checkbox" value="{{ $tech->id }}" name="technologies[]">
                    <label class="form-check-label">{{ $tech->name }}</label>
                    @error('technology')
                    <div class="invalid-feedback">{{ message }}</div>
                    @enderror
                </div>    
                @endforeach
                <div class="form-group mt-3">
                    <label class="control-label">
                         Contenuto
                    </label>
                    <input type="text" class="form-control" placeholder="Contenuto" id="content" name="content">
                </div>
                <div class="form-group my-3">
                    <button type="submit" class="btn btn-success">Salva il Progetto</button>
                </div>
            </form>
        </div>    
    </div>
</div>
@endsection