@extends('app')

@section('content')

    <div class="container">
        <h2>{{ $experiment->title }}</h2>
        <p>{{ $experiment->text }}</p>

        <a class="btn btn-default btn-primary" href="/experiment/{{$experiment->key}}/{{$element->id}}">Start des Experimentes</a>
    </div>

@stop