@extends('layouts.main')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-dark">
    <h1 class="text-center">Edit Postingan</h1>
</div>
<div class="col-lg-8">
    <form action="update" method="post" class="mb-5" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="mb-3">
          <label for="title" class="form-label">Nama Barang</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}">
          @error('title')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <input type="hidden" class="form-control" id="slug" name="slug" readonly value="{{ old('slug', $post->slug) }}">
        </div>
        <div class="mb-3">
          <label for="category" class="form-label">Kategori</label>
          <select class="form-select" name="category_id" required>
            @foreach ($categories as $category)
            @if (old('category_id', $post->category_id) == $category->id)
            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
            @else
            <option value="{{ $category->id }}">{{ $category->name }}</option>    
            @endif    
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="condition" class="form-label">Kondisi</label>
          <select class="form-select" name="condition_id" required>
            @foreach ($conditions as $condition)
            @if (old('condition_id', $post->condition_id) == $condition->id)
            <option value="{{ $condition->id }}" selected>{{ $condition->name }}</option>
            @else
            <option value="{{ $condition->id }}">{{ $condition->name }}</option>    
            @endif    
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="image" class="form-label">Gambar</label>
          <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
          @error('image')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="body" class="form-label">Deskripsi</label>
            <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
            <trix-editor input="body"></trix-editor>
            @error('body')
              <p class="text-danger">
                {{ $message }}
              </p>
          @enderror
            
        </div>
        
        <button type="submit" class="btn btn-primary mb-3">Update Postingan</button>
    </form>
</div>

<script>
    const title = document.querySelector("#title");
const slug = document.querySelector("#slug");

title.addEventListener("change", function () {
    fetch("/dashboard/create/checkSlug?title=" + title.value)
        .then((response) => response.json())
        .then((data) => (slug.value = data.slug));
});

document.addEventListener("trix-file-accept", function(e){
    e.preventDefault();
});
</script>
@endsection