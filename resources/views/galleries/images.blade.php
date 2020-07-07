
@extends('templates.layout')

@section('content')
@if (session()->has('message'))
@component('components.allerta')
    {{session()->get('message')}}
@endcomponent
@endif
    <div>
        album {{$album->id}} || album name -> {{$album->album_name}}
    </div>

<div class="galleryImages">


    @forelse ($images as $image)
            <div class="imgBox imgGalleryBox">

                <img src="{{asset($image->path)}}" alt="{{asset($image->path)}}" width="120">
            </div>




        @empty
        <div>

            no images
        </div>
        @endforelse
</div>

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
