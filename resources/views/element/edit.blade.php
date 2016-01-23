{!! Form::model($element, array('url' => 'element/'.$element->id, 'method' => 'patch', 'class'=>'element'.$element->id)) !!}
    <div class="form-group">
        {!! Form::label('title', 'Titel:') !!}
        {!! Form::text('title', null,array('class'=>'form-control')) !!}<br>
    </div>
    <div class="form-group">
        {!! Form::label('content', 'Inhalt:') !!}
        {!! Form::textarea('content', null, array('class'=>'form-control')) !!}<br>
    </div>
    {!! Form::submit("Speichern", array('class'=>'btn btn-default')) !!} <input type="button" value="Löschen" class="delete btn btn-default">
{!! Form::close() !!}

