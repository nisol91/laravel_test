@php

// dd($albums);
@endphp

@extends('templates.layout')

@section('title', $title)

<h1 >{{$title}}</h1>
@section('content')
<form action="{{route('saveNewAlbum')}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}


    <div class="form-group">

      <label for="">Name</label>
    <input type="text" name="name" id="" class="form-control" placeholder="name" aria-describedby="helpId" value="">
      <label for="">Description</label>
      <textarea name="description" id="" class="form-control" placeholder="desc" aria-describedby="helpId"></textarea>
    </div>
     <div class="form-group">

      <label for="">Thumb</label>
    <input type="file" name="album_thumb" id="" class="form-control" placeholder="album_thumb" aria-describedby="helpId" value="" >

    </div>
    {{-- <input type="hidden" name="user_id" value="1"> --}}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
