@extends('app')

@section('content')

<style>


.glyphicon-remove {
    display: none;
}
.glyphicon-ok {
    display: none;
}
.has-error .glyphicon-remove {
    display: block;
}
.has-success .glyphicon-ok {
    display: block;
}
select.form-control {
    width: calc(100% - 35px)
}

</style>


<script>
    var check = false;
    $(function() {
        $('.validate').submit(function() {
            check = true;

            $(this).find('.required[type=text]').each(function() {
                validateClass($(this),$(this).val() != "");
            });
            $(this).find('select.required').each(function() {
                validateClass($(this),$(this).val() != "");
            });
            $(this).find('.required[type=radio]').each(function() {
                validateClass($(this),$(this).parent().find('.required[type=radio]:checked').length == 1);
            });
            $(this).find('textarea.required').each(function() {
                validateClass($(this),$(this).val() != "");
            });

            return check;
        });


        var eventRequire = function() {

            if($(this).attr('type') == 'text' || $(this).is('select')) {
                validateClass($(this),$(this).val() != "");
            }
            if($(this).is('textarea')) {
                validateClass($(this),$(this).val() != "");
            }
            if($(this).attr('type') == 'radio') {
                validateClass($(this),$(this).parent().find('.required[type=radio]:checked').length == 1);
            }


        };
        $('.required').change(eventRequire);
        $('.required').keyup(eventRequire);



        $('.validate .required[type=text]').change(function() {

        });
        $('.validate .required[type=checkbox]').change(function() {
            validateClass($(this),$(this).val() != "");
        });


    });

    function validate(element) {

    }

    function validateClass(element, bool) {
        if(bool) {
            element.parent().addClass('has-success')
            element.parent().removeClass('has-error')
        } else {
            check = false;
            element.parent().addClass('has-error')
            element.parent().removeClass('has-success')
        }
    }

</script>

    @if($element->type == 1)
        <div class="container">
            <h2>{{ $element->title }}</h2>
            <p>{{ $element->content }}</p>

            @if($next<count($elements))
                <a class="btn btn-default" href="/experiment/{{$experiment->key}}/{{$next}}">weiter</a>
            @else
                <a class="btn btn-default" href="/danke">weiter</a>
            @endif
        </div>
    @elseif($element->type == 2)
        <div class="container">
            <h2>{{ $element->title }}</h2>
            <p>{{ $element->content }}</p>

            {!! Form::open(array('url' => "/experiment/".$experiment->key."/".$element->id.'/save', 'method' => 'post','class'=>'form-horizontal validate')) !!}
                @if($next<count($elements))
                {!! Form::hidden("url", "/experiment/".$experiment->key."/".$next) !!}
                @else
                    {!! Form::hidden("url", "/danke") !!}
                @endif
            @foreach($element->fields as $field)
                    <div class="form-group has-feedback">
                        {!! Form::label($field->id, $field->name." ".(($field->validation!='')?'*':''), array('class'=>'col-sm-3 control-label')) !!}
                        <div class="col-sm-9">
                            @if($field->type == 1)
                                {!! Form::text("form[".$field->id."]", null, array('class'=>'form-control '.$field->validation)) !!}
                            @elseif($field->type == 2)
                                {!! Form::textarea("form[".$field->id."]", null, array('class'=>'form-control '.$field->validation)) !!}
                            @elseif($field->type == 3)
                                {!! Form::select("form[".$field->id."]", array_merge(['' => 'Bitte auswählen'], explode("\n",$field->settings)), null, array('class'=>'form-control '.$field->validation)) !!}
                            @elseif($field->type == 4)
                                @foreach(explode("\n",$field->settings) as $key=>$wert)
                                {!! Form::radio("form[".$field->id."]", $key,  null, array('class'=>$field->validation)) !!} {{$wert}}<br>
                                @endforeach
                            @elseif($field->type == 5)
                                @foreach(explode("\n",$field->settings) as $key=>$wert)
                                    {!! Form::checkbox("form[".$field->id."][]", $key, null) !!} {{$wert}}<br>
                                @endforeach
                            @endif
                            <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>

                        </div>
                    </div>
                @endforeach
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        {!! Form::submit("weiter", array('class'=>'btn btn-default')) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    @elseif($element->type == App\Element::MODEL)

            <div id="row">
                <div class="col-sm-offset-9 col-sm-3"><h2>{{ $element->title }}</h2>
                    <p>{{ $element->content }}</p>
                    @if($next<count($elements))
                        <a class="btn btn-default" href="/experiment/{{$experiment->key}}/{{$next}}">weiter</a>
                    @else
                        <a class="btn btn-default" href="/danke">weiter</a>
                    @endif
                </div>

            </div>

                <link rel="stylesheet" href="/modeler/dist/css/diagram-js.css" />
                <link rel="stylesheet" href="/modeler/dist/vendor/bpmn-font/css/bpmn-embedded.css" />
                <link rel="stylesheet" href="/modeler/app/css/app.css" />


            <div class="content" experiment="{{$experiment->key}}" element="{{$element->id}}"  id="#js-drop-zone">

                <div class="canvas" id="js-canvas"></div>
            </div>

            <script src="/modeler/dist/index.js"></script>
            {!! Form::open(array('url' => "/experiment/".$experiment->key."/".$element->id.'/draw', 'method' => 'post','class'=>'form-horizontal token')) !!}
            {!! Form::close() !!}
    @elseif($element->type == 4)
        <div class="container">
            <h2>{{ $element->title }}</h2>
            <p>{{ $element->content }}</p>


            {!! Form::open(array('url' => "/experiment/".$experiment->key."/".$element->id.'/save', 'method' => 'post','class'=>'form-horizontal validate')) !!}
            @if($next<count($elements))
                {!! Form::hidden("url", "/experiment/".$experiment->key."/".$next) !!}
            @else
                {!! Form::hidden("url", "/danke") !!}
            @endif
            {!! Form::textarea("form[feedback]", null, array('class'=>'form-control')) !!}
            <div>&nbsp;</div>
            <div class="form-group">
                <div class=" col-sm-9">
                    {!! Form::submit("weiter", array('class'=>'btn btn-default')) !!}
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    @endif
@stop