
@extends('templates.layout')

@section('content')
@if (session()->has('message'))
@component('components.allerta')
    {{session()->get('message')}}
@endcomponent
@endif
<table class="table table-bordered">
    <div>
        album {{$album->id}} || album name -> {{$album->album_name}}
    </div>
    <div>
        {{-- nb passo l album id nell'url!!!!! --}}
    <a href="{{route('photos.create', ['album' => $album->id])}}" class="btn btn-dark">New Image</a>

    </div>
    <tr>
        <th>id</th>
        <th>created date</th>
        <th>author</th>
        <th>title</th>
        <th>album</th>
        <th>thumb</th>
        <th>img</th>

        <th></th>

    </tr>

    @forelse ($images as $image)
        <tr>
        <td>{{$image->id}}</td>
        <td>{{$image->created_at}}</td>
        <td>{{$image->album->user->fullname}}</td>

        <td>{{$image->name}}</td>
        <td>{{$album->album_name}}</td>
        <td><img src="{{asset($album->path)}}" alt="{{$album->album_name}}" width="120"></td>
        <td><img src="{{asset($image->path)}}" alt="{{asset($image->path)}}" width="120"></td>


        <td>
        <a title="delete" href="{{route('photos.destroy', $image->id)}}" class="btn btn-danger deletePhoto"> <i class="fas fa-minus"></i></a>
            <a href="{{route('photos.edit', $image->id)}}" class="btn btn-primary">edit</a>

        </td>



        </tr>
        @empty
            <tr>
                <td>
                    no images
                </td>
            </tr>
        @endforelse
</table>
<div>
    {{$images->links('vendor.pagination.bootstrap-4')}}
</div>
@endsection
@section('footer')
@parent
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('.allerta').fadeOut(4000);

            $('.deletePhoto').click(function (e) {
                e.preventDefault();
                var urlPhoto = $(this).attr('href');
                var td = $(this).parent().parent();
                console.log(td);
                console.log(urlPhoto);



                // per cancellare dinamicamente il dato, faccio una chiamata alla mia rotta,
                // di fatto chiamo la mia api laravel
                // alla rotta che corrisponde al metodo delete del controller
                $.ajax({
                    type: "DELETE",
                    url: urlPhoto,
                    data: {
                            "_token": '{{ csrf_token() }}'

                        },
                    success: function (response) {
                        console.log(response)
                            if (response == 1) {

                                $(td).remove();
                            } else {
                                console.log('error');

                            }
                    }
                });


            });
        });
    </script>
@endsection
