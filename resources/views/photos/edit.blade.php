@php

// dd($albums);
@endphp

@extends('templates.layout')

@section('title', $title)

<h1 >{{$title}} {{$id}}</h1>
@section('content')
    @include('partials.errors_form')

<form action="{{route('photos.update', $photo->id)}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{-- equivale a --}}
    {{-- <input type="hidden" value="{{ csrf_token() }}" id="_token" name="_token"> --}}


    {{-- laravel dirotta la post alla patch, per modificare i fields --}}
    {{-- <input type="hidden" name="_method" value="PATCH"> --}}
   {{method_field('PATCH')}}


    <div class="form-group">

      <label for="">Name</label>
    <input type="text" name="name" id="" class="form-control" placeholder="name" aria-describedby="helpId" value="{{$photo->name}}">
      <label for="">Description</label>
      <textarea name="description" id="" class="form-control" placeholder="desc" aria-describedby="helpId">{{$photo->description}}</textarea>

    </div>
    <div class="form-group">
        <select name="album_id" id="album_id">
            <option value="">select album</option>
        @foreach ($albums as $item)
        <option {{($item->id == $album->id)?'selected':''}} value="{{$item->id}}">{{$item->album_name}}</option>
        @endforeach
        </select>

    </div>
    @include('photos.partials.fileupload')
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
