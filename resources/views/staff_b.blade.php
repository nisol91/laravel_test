<h1>staff</h1>
@extends('templates.layout')

@section('title', $title)

@section('content')

{{$title}}
@if($dataStaff)
        <div class="staffBox" >
    @foreach ($dataStaff as $person)
    <h1 style={{$loop->last ? "color:blue":""}}> index->{{$loop->index}} remaining->{{$loop->remaining}}{{$person['name']}}  {{$person['lastname']}} </h1>
    @endforeach
</div>
@else
<div>
    no staff
</div>
@endif
<h1>ciclo classico for</h1>
@for ($i = 0; $i < count($dataStaff); $i++)
<h6>{{$dataStaff[$i]['name']}}</h6>
<h6>{{$dataStaff[$i]['lastname']}}</h6>



@endfor
{{$myName}}

{{-- nuova sintassi componente --}}
<x-alert style="color:blue" :info="'info'" :message="'ooo'" :name="$myName"  />

{{-- vecchia sintassi componente --}}
@component('components.card', ['img_title'=> 'image staff', 'img_url'=>'https://wallpaperplay.com/walls/full/e/5/3/13586.jpg'])
<p>this is a test image, this text is in the @ slot</p>
@endcomponent
@endsection
@section('footerYeld')
    footer yeld
@endsection
@section('footer')
@parent
    <h1>footer children</h1>
@endsection
