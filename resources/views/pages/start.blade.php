@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Experiment</div>
                    <div class="panel-body">

                        {!! Form::open() !!}

                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>


                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Schlüssel</span>
                                {!! Form::text('key','',array('class'=>'form-control', 'aria-label'=>'Text input with multiple buttons')) !!}
                                <div class="input-group-btn">
                                    {!! Form::submit('Eingabe',array('class'=>'btn btn-primary')) !!}

                                </div>
                            </div>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop