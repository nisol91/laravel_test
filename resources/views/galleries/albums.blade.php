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
@if (count($albums) !== 0)
<div class="cardBox">

    @foreach ($albums as $album)
    <div class="card carta" id="row{{$album->id}}" style="width: 18rem;">
  @if ($album->album_thumb)
        <div class="">
            <img src="{{asset($album->path)}}" alt="{{$album->album_name}}">
        </div>
    @endif
  <div class="card-body">
    <h5 class="card-title">{{$album->album_name}} - {{$album->id}}</h5>
    <h5 class="card-title">{{$album->user->name}}</h5>
    <div class="flex_1">
@foreach ($album->categories as $item)
    <h5 class="card-title">{{$item->category_name}}</h5>
    @endforeach
    </div>



    <h5 class="card-title">{{$album->created_at->diffForHumans()}}</h5>
  <a href="{{route('getGalleryImages', $album->id)}}">go to gallery</a>

  </div>
</div>

    @endforeach

</div>
<div>
    {{$albums->links('vendor.pagination.bootstrap-4')}}
</div>
@else
<h2>no albums found</h2>
@endif

@endsection
@section('footer')
@parent
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('.allerta').fadeOut(4000);

            // METODO CON FORM
            $('.deleteAlbumButton').click(function (e) {
                e.preventDefault();
                var id = e.target.id;
                var form = $('#form' + id);
                var action = form.attr('action');
                var row = $('#row' + id)
                console.log(action);
                // qui invece che puntare con un href punto con un form al metodo delete, ma è analogo
                // la differenza è che se anche l'ajax non funzionasse, lui elimina lo stesso perchè mi fa un redirect
                // (vedi metodo nel controller)
                $.ajax({
                    type: "DELETE",
                    url: action,
                    data: {
                            "_token": '{{ csrf_token() }}'
                        },
                    success: function (response) {
                        console.log(response)
                            if (response == 1) {

                                $(row).remove();
                            } else {
                                console.log('error');

                            }
                    }
                });
            });



            // METODO CON HREF
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
                            // "_token": $('#_token').val()
                            "_token": '{{ csrf_token() }}'
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
