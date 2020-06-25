@php

// dd($albums);
@endphp

@extends('templates.layout')

@section('title', $title)

<h1 >{{$title}}</h1>

@section('content')
<form action="{{route('photos.store')}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

{{$album->id}}
    <div class="form-group">
      <label for="">Name</label>
    <input type="text" name="name" id="" class="form-control" placeholder="name" aria-describedby="helpId" value="">
      <label for="">Description</label>
      <textarea name="description" id="" class="form-control" placeholder="desc" aria-describedby="helpId"></textarea>
    </div>
     <div class="form-group">

      <label for="">Thumb</label>
    <input type="file" name="img_path" id="" class="form-control" placeholder="img_path" aria-describedby="helpId" value="" >

    </div>
<input type="hidden" name="album_id" value="{{$album->id}}">
    <button type="submit" class="btn btn-primary">Create new image</button>
</form>

@endsection
