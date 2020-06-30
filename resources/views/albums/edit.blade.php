@php

// dd($albums);
@endphp

@extends('templates.layout')

@section('title', $title)

<h1 >{{$title}} {{$id}}</h1>
@section('content')
    @include('partials.errors_form')

<form action="/albums/{{$id}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{-- equivale a --}}
    {{-- <input type="hidden" value="{{ csrf_token() }}" id="_token" name="_token"> --}}


    {{-- laravel dirotta la post alla patch, per modificare i fields --}}
   {{method_field('PATCH')}}

    <div class="form-group">

      <label for="">Name</label>
    <input type="text" name="name" id="" class="form-control" placeholder="name" aria-describedby="helpId" value="{{$album->album_name}}">
      <label for="">Description</label>
      <textarea name="description" id="" class="form-control" placeholder="desc" aria-describedby="helpId">{{$album->description}}</textarea>

    </div>
    @include('albums.partials.fileupload')
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
