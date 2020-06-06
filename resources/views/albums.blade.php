@php

// dd($albums);
@endphp

@extends('templates.layout')

@section('title', $title)

@section('content')
<h1>{{$title}}</h1>
<ul class="list-group">
    @foreach ($albums as $album)
    <li class="list-group-item">
        {{$album->album_name}} {{$album->id}}
        <a href="/albums/{{$album->id}}/delete" class="btn btn-danger">delete</a>
    </li>
    @endforeach
</ul>

@endsection
@section('footer')
@parent
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('a').click(function (e) {
                e.preventDefault();
                var urlAlbum = $(this).attr('href');
                console.log(urlAlbum);

            });
        });
    </script>
@endsection
