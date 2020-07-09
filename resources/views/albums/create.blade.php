@php

// dd($albums);
@endphp

@extends('templates.layout')

@section('title', $title)

<h1 >{{$title}}</h1>
@section('content')
    @include('partials.errors_form')

<form action="{{route('saveNewAlbum')}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}


    <div class="form-group">

      <label for="">Name</label>
    <input type="text" required name="name" id="" class="form-control" placeholder="name" aria-describedby="helpId" value="{{old('name')}}">
      <label for="">Description</label>
      {{-- old mi permette di tenere  valori che hanno passato la validazione --}}
      <textarea name="description" required id="" class="form-control" placeholder="desc" aria-describedby="helpId">{{old('description')}}</textarea>
    </div>
     <div class="form-group">

      <label for="">Thumb</label>
    <input required type="file" name="album_thumb" id="" class="form-control" placeholder="album_thumb" aria-describedby="helpId" value="" >

    </div>
     <div class="form-group">
         <label for="categories">Categories</label>
         {{-- nb ricorda che serve [] se usi select multiple --}}
         <select name="categories[]" id="categories" multiple class="form-control" size="5">
             @foreach ($categories as $category)
         <option value="{{$category->id}}">{{$category->category_name}}</option>
             @endforeach
         </select>
     </div>
    {{-- <input type="hidden" name="user_id" value="1"> --}}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
