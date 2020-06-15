@php

// dd($albums);
@endphp

@extends('templates.layout')

@section('title', $title)

@section('content')
<h1>{{$title}}</h1>
@if (session()->has('message'))


@component('components.allerta')
    {{session()->get('message')}}
@endcomponent

@endif

<form action="">
    <input type="hidden" value="{{ csrf_token() }}" id="_token" name="_token">
</form>
<ul class="list-group">
    @foreach ($albums as $album)
    <li class="list-group-item albumListElement">
        {{$album->album_name}} {{$album->id}}
        @if ($album->album_thumb)
        <div class="imgBox">
            <img src="{{asset($album->path)}}" alt="{{$album->album_name}}">
        </div>
    @endif
        <div>

            <a href="/albums/{{$album->id}}/edit" class="btn btn-primary">edit</a>
            <a href="/albums/{{$album->id}}" class="btn btn-danger deleteAlbum">delete</a>
        </div>

    </li>
    @endforeach
</ul>

@endsection
@section('footer')
@parent
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('.allerta').fadeOut(4000);

            $('.deleteAlbum').click(function (e) {
                e.preventDefault();
                var urlAlbum = $(this).attr('href');
                var li = $(this).offsetParent();
                console.log(li);
                console.log(urlAlbum);



                // per cancellare dinamicamente il dato, faccio una chiamata alla mia rotta,
                // di fatto chiamo la mia api laravel
                // alla rotta che corrisponde al metodo delete del controller
                $.ajax({
                    type: "DELETE",
                    url: urlAlbum,
                    data: {
                            "_token": $('#_token').val()
                        },
                    success: function (response) {
                        console.log(response)
                            if (response == 1) {

                                $(li).remove();
                            } else {
                                console.log('error');

                            }
                    }
                });

                //altro modo per fare la chiamata ajax
                // $.ajax(
                //     urlAlbum,
                //     {
                //         method: 'DELETE',
                //         data: {
                //             "_token": $('#_token').val();
                //         },
                //         complete: function (response) {
                //             console.log(response)
                //             if (response.responseText == 1) {

                //                 $(li).remove();
                //             } else {
                //                 console.log('error');

                //             }

                //         }
                //     }
                // );
            });
        });
    </script>
@endsection
