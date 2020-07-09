@php

// dd($categories);
@endphp

@extends('templates.layout')

@section('title', $title ?? '')

@section('content')
<h1>{{$title ?? ''}}</h1>
@if (session()->has('message'))


@component('components.allerta')
{{session()->get('message')}}
@endcomponent

@endif

<form action="">
    <input type="hidden" value="{{ csrf_token() }}" id="_token" name="_token">
</form>
@if (count($categories) !== 0)
<ul class="list-group">

    @foreach ($categories as $category)
    <li class="list-group-item albumListElement" id="row{{$category->id}}">
        {{$category->category_name}} {{$category->id}}
        @if ($category->album_thumb)
        <div class="imgBox">
            <img src="{{asset($category->path)}}" alt="{{$category->album_name}}">
        </div>
        @endif

            <div>
                {{$category->created_at}}
            </div>
            @if ($category->photos_count)

            <a href="{{route('albumImages',$category->id )}}" class="btn btn-primary">view
                images({{$category->photos_count}})</a>
            @else
            <a href="{{route('albumImages',$category->id )}}" class="btn btn-primary">add your first images</a>

            @endif

            <a href="{{route('editAlbum',$category->id )}}" class="btn btn-primary">edit</a>

            {{-- metodo con form --}}
            <form id="form{{$category->id}}" action="{{route('deleteAlbum',$category->id )}}" method="post">
                @csrf
                @method('DELETE')
                <button id="{{$category->id}}" class="btn btn-danger deleteAlbumButton">delete with form</button>
            </form>

            {{-- metodo con href --}}
            <a href="{{route('deleteAlbum', $category->id)}}" class="btn btn-danger deleteAlbum">delete with href</a>
        </div>

    </li>
    @endforeach

</ul>
<div>
    {{-- {{$categories->links('vendor.pagination.bootstrap-4')}} --}}
</div>
@else
<h2>no categories found</h2>
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
