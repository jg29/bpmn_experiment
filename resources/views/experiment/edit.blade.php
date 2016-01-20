@extends('app')

@section('content')


    <div class="form">

        <h1>Bearbeite: {!! $experiment->title !!}</h1>

        {!! Form::model($experiment,array('url' => 'experiment/'.$experiment->id, 'method' => 'patch')) !!}
            @include('experiment.form',['submitButtonText'=>'Bearbeiten'])
        {!! Form::close() !!}

        @include('errors.list')
    </div>
@stop