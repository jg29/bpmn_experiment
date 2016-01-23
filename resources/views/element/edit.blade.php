{!! Form::model($element, array('url' => 'element/'.$element->id, 'method' => 'patch', 'class'=>'element'.$element->id)) !!}
    <div class="form-group">
        {!! Form::label('title', 'Titel:') !!}
        {!! Form::text('title', null,array('class'=>'form-control')) !!}<br>
    </div>
    <div class="form-group">
        @if($element->type == 1)
            {!! Form::label('content', 'Text für Teilnehmer:') !!}
        @elseif($element->type == 2)
            {!! Form::label('content', 'Fragebogen Editieren:') !!}
        @elseif($element->type == 3)
            {!! Form::label('content', 'Text für Teilnehmer:') !!}
        @elseif($element->type == 4)
            {!! Form::label('content', 'Text für Teilnehmer:') !!}
        @elseif($element->type == 5)

        @endif
        {!! Form::textarea('content', null, array('class'=>'form-control')) !!}<br>
    </div>
    {!! Form::submit("Speichern", array('class'=>'btn btn-default')) !!} <input type="button" value="Löschen" class="delete btn btn-default">
{!! Form::close() !!}

