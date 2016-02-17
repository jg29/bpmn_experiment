@extends('app')

@section('content')

    <div class="container">
        <div class="form">

            <h2>Bearbeiten</h2>

            {!! Form::model($user      , array('url' => 'user/'.$user->id, 'method' => 'patch','class'=>'form-horizontal')) !!}



            <div class="form-group">
                {!! Form::label('name', 'Name:', array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-5">
                    {!! Form::text('name', null,array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', 'E-Mail:', array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-5">
                    {!! Form::text('email', null,array('class'=>'form-control')) !!}
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('groups', 'Rechte:', array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-5">
                    <input type="checkbox" name="recht[]" {{ $user->isAdmin() ? "checked" : "" }} value="1"> Admin<br>
                    <input type="checkbox" name="recht[]" {{ $user->isEditor() ? "checked" : "" }} value="2"> Bearbeiter
                </div>

            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-5">
                    {!! Form::submit("Speichern", array('class'=>'btn btn-default')) !!}
                </div>
            </div>


            {!! Form::close() !!}
        </div>
    </div>
@stop