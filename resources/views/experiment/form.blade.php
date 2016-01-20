{!! Form::label('title', 'Experimentenname:') !!}
{!! Form::text('title') !!}<br>

{!! Form::label('text', 'Beschreibungstext:') !!}
{!! Form::textarea('text') !!}<br>
{!! Form::submit($submitButtonText) !!}