@extends('app')

@section('content')


    <div class="form">

        <h1>Neues Experiment</h1>

        {!! Form::open(array('url' => 'experiment', 'method' => 'post')) !!}
            @include('experiment.form',['submitButtonText'=>'Erstellen'])
        {!! Form::close() !!}

        @include('errors.list')
    </div>
@stop