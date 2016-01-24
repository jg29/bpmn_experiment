<div class="form-group">
    {!! Form::label('title', 'Experimentenname:', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-5">
        {!! Form::text('title', null,array('class'=>'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('text', 'Beschreibungstext:', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-5">
        {!! Form::textarea('text', null,array('class'=>'form-control')) !!}
    </div>

</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-5">
        {!! Form::submit($submitButtonText, array('class'=>'btn btn-default')) !!}
    </div>
</div>