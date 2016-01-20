@extends('app')

@section('content')
    <a href="auth/login">Login</a>


<div class="form">

    <h1>Experiment</h1>

    {!! Form::open() !!}
    {!! Form::label('key', 'Schlüssel:') !!}
    {!! Form::text('key') !!}<br>
    {!! Form::submit('Start') !!}
    {!! Form::close() !!}



</div>
@stop