@extends('app')

@section('content')

    <div class="container">
        @if($element->type == 1)
            <h2>{{ $element->title }}</h2>
            <p>{{ $element->content }}</p>

            @if($element->next() != null)
                <a class="btn btn-default" href="/experiment/{{$experiment->key}}/{{$element->next()->id}}">weiter</a>
            @else
                <a class="btn btn-default" href="/danke">weiter</a>
            @endif
        @elseif($element->type == 2)
            <h2>{{ $element->title }}</h2>
            <p>{{ $element->content }}</p>

            {!! Form::open(array('url' => "/experiment/".$experiment->key."/".$element->id.'/save', 'method' => 'post','class'=>'form-horizontal')) !!}
                @if($element->next() != null)
                {!! Form::hidden("url", "/experiment/".$experiment->key."/".$element->next()->id) !!}
                @else
                    {!! Form::hidden("url", "/danke") !!}
                @endif
            @foreach($element->fields as $field)
                    <div class="form-group">
                        {!! Form::label($field->id, $field->name, array('class'=>'col-sm-3 control-label')) !!}
                        <div class="col-sm-9">
                            @if($field->type == 1)
                                {!! Form::text($field->id, null, array('class'=>'form-control')) !!}
                            @elseif($field->type == 2)
                                {!! Form::textarea($field->id, null, array('class'=>'form-control')) !!}
                            @elseif($field->type == 3)
                                {!! Form::select($field->id, explode("\n",$field->settings), null, array('class'=>'form-control')) !!}
                            @elseif($field->type == 4)
                                @foreach(explode("\n",$field->settings) as $key=>$wert)
                                {!! Form::radio($field->id, $key) !!} {{$wert}}<br>
                                @endforeach
                            @elseif($field->type == 5)
                                @foreach(explode("\n",$field->settings) as $key=>$wert)
                                    {!! Form::checkbox($field->id."[]", $key) !!} {{$wert}}<br>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        {!! Form::submit("weiter", array('class'=>'btn btn-default')) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        @elseif($element->type == 3)
            <h2>{{ $element->title }}</h2>
            <p>{{ $element->content }}</p>


                <link rel="stylesheet" href="/modeler/dist/css/diagram-js.css" />
                <link rel="stylesheet" href="/modeler/dist/vendor/bpmn-font/css/bpmn-embedded.css" />
                <link rel="stylesheet" href="/modeler/app/css/app.css" />


            <div class="content" id="#js-drop-zone">

                <div class="canvas" id="js-canvas"></div>
            </div>

            <script src="/modeler/dist/index.js"></script>
       @if($element->next() != null)
                <a class="btn btn-default" href="/experiment/{{$experiment->key}}/{{$element->next()->id}}">weiter</a>
            @else
                <a class="btn btn-default" href="/danke">weiter</a>
            @endif
        @elseif($element->type == 4)
            <h2>{{ $element->title }}</h2>
            <p>{{ $element->content }}</p>

            TODO Feedback
            @if($element->next() != null)
                <a class="btn btn-default" href="/experiment/{{$experiment->key}}/{{$element->next()->id}}">weiter</a>
            @else
                <a class="btn btn-default" href="/danke">weiter</a>
            @endif
        @elseif($element->type == 5)
            <h2>Aufgabe</h2>

            <p>{{ $field->settings }}</p>


            @if($element->next() != null)
                <a class="btn btn-default" href="/experiment/{{$experiment->key}}/{{$element->next()->id}}">weiter</a>
            @else
                <a class="btn btn-default" href="/danke">weiter</a>
            @endif
        @endif

    </div>

@stop