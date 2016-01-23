@extends('app')

@section('content')


    <div class="container">

        <h2>Neues Experiment</h2>

        {!! Form::open(array('url' => 'experiment', 'method' => 'post','class'=>'form-horizontal')) !!}
            @include('experiment.form',['submitButtonText'=>'Erstellen'])
        {!! Form::close() !!}

        @include('errors.list')
    </div>
@stop