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
@endsection
@section('footer')
@parent
    <h1>footer children</h1>
@endsection
