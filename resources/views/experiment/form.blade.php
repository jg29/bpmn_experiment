<div class="form-group">
    {!! Form::label('title', 'Experimentenname:', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('title', '',array('class'=>'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('text', 'Beschreibungstext:', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::textarea('text', '',array('class'=>'form-control')) !!}
    </div>

</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, array('class'=>'btn btn-default')) !!}
    </div>
</div>