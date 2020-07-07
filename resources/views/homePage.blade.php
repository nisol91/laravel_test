@extends('templates.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (Auth::check())
<div class="alert alert-success" role="alert">
                           Benvenuto in Laravel test
                        </div>

                    @endif


            </div>
        </div>
    </div>
</div>
@endsection
