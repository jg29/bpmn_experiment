@if($element->type != 5)
{!! Form::model($element, array('url' => 'element/'.$element->id, 'method' => 'patch', 'class'=>'element'.$element->id.' form-horizontal','style'=>'margin-top:20px;')) !!}
    <div class="form-group">
        {!! Form::label('title', 'Titel:',array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9"  style="padding-bottom: 5px;">
            {!! Form::text('title', null,array('class'=>'form-control')) !!}
        </div>
    </div>
    <div class="form-group"">
        @if($element->type == 1)
            {!! Form::label('content', 'Erklärungstext:', array('class'=>'col-sm-3 control-label')) !!}
        @elseif($element->type == 2)
            {!! Form::label('content', 'Erklärungstext:', array('class'=>'col-sm-3 control-label')) !!}
        @elseif($element->type == 3)
            {!! Form::label('content', 'Erklärungstext:', array('class'=>'col-sm-3 control-label')) !!}
        @elseif($element->type == 4)
            {!! Form::label('content', 'Erklärungstext:', array('class'=>'col-sm-3 control-label')) !!}
        @elseif($element->type == 5)
            {!! Form::label('content', 'Erklärungstext:', array('class'=>'col-sm-3 control-label')) !!}
        @endif
        <div class="col-sm-9"  style="padding-bottom: 5px;">
            {!! Form::textarea('content', null, array('class'=>'form-control')) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            {!! Form::submit("Speichern", array('class'=>'btn btn-default')) !!}
            <input type="button" value="Löschen" class="delete btn btn-default">
        </div>
    </div>
{!! Form::close() !!}

<div>&nbsp;</div>

@endif
@if($element->type == 2)
<table class="table table-striped nomargin">
    <thead>
        <tr>
            <th width="30%">Title</th>
            <th width="30%">Type</th>
            <th width="30%">Wert</th>
            <th width="10%">&nbsp;</th>
        </tr>
    </thead>
</table>
<div class="forms">
    @forelse($fields as $field)
        {!! Form::model($field, array('url' => 'field/'.$field->id, 'method' => 'patch')) !!}
        <table class="table table-striped nomargin">
            <tr>

                <td width="30%">{!! Form::text('name', null,array('class'=>'form-control input-sm')) !!}</td>
                <td width="30%">{!! Form::select('type', array('1'=>'Textfeld','2'=>'Textarea', '3'=>'Select', '4'=>'Radio', '5'=>'Checkbox'),null,array('class'=>'form-control input-sm')) !!}</td>
                <td width="30%">
                        @if($field->type == 1)

                        @elseif($field->type == 2)

                        @elseif($field->type == 3)
                            {!! Form::textarea('settings', null,array('class'=>'form-control input-sm','style'=>'height:100px')) !!}
                        @elseif($field->type == 4)
                            {!! Form::textarea('settings', null,array('class'=>'form-control input-sm','style'=>'height:100px')) !!}
                        @elseif($field->type == 5)
                            {!! Form::textarea('settings', null,array('class'=>'form-control input-sm','style'=>'height:100px')) !!}
                        @endif
                </td>
                <td width="10%">
                    <a href="#" id="{{ $field->id }}" class="up"><span class="glyphicon glyphicon-chevron-up"></span></a>
                    <a href="#" onclick="$(this).parents('form').submit();return false"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></a><br>

                    <a href="#" id="{{ $field->id }}" class="down"><span class="glyphicon glyphicon-chevron-down"></span></a>
                    <a href="#" onclick="$('.form{{$field->id}}').submit();return false"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                </td>

            </tr>
        </table>
        {!! Form::close() !!}
        {!! Form::open(array('route' => array('field.destroy', $field->id), 'method' => 'delete','class'=>'form'.$field->id)) !!}{!! Form::close()  !!}

    @empty
        <div>kein Feld gefunden</div>

    @endforelse
</div>
{!! Form::open(array('url' => 'field', 'method' => 'post')) !!}
    <table class="table table-striped nomargin">
        <tr>
            <td colspan="4"><b>Neues Element:</b></td>
        </tr>
        <tr>
            {!! Form::hidden('element_id', $element->id) !!}
            <td width="30%" style="border: 0;">{!! Form::text('name', null,array('class'=>'form-control input-sm')) !!}</td>
            <td width="30%" style="border: 0;">{!! Form::select('type', array('1'=>'Textfeld','2'=>'Textarea', '3'=>'Select', '4'=>'Radio', '5'=>'Checkbox'),null,array('class'=>'form-control input-sm')) !!}</td>
            <td width="30%" style="border: 0;">{!! Form::textarea('settings', null,array('class'=>'form-control input-sm','style'=>'height:100px')) !!}</td>
            <td width="10%" style="border: 0;"> <a href="#" onclick="$(this).parents('form').submit();return false"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></a></td>

        </tr>
    </table>
{!! Form::close() !!}



@endif

@if($element->type == 5)
    {!! Form::model($element, array('url' => 'element/'.$element->id, 'method' => 'patch', 'class'=>'element'.$element->id.' form-horizontal','style'=>'margin-top:20px;')) !!}
        <input type="button" value="Element Löschen" class="delete btn btn-default">
    {!! Form::close() !!}
    <table class="table table-striped nomargin">
        <thead>
        <tr>
            <th width="30%">Title</th>
            <th width="60%">Text</th>
            <th width="10%">&nbsp;</th>
        </tr>
        </thead>
    </table>
    <div class="forms">
        @forelse($fields as $field)
            {!! Form::model($field, array('url' => 'field/'.$field->id, 'method' => 'patch')) !!}
            <table class="table table-striped nomargin">
                <tr>

                    <td width="30%">{!! Form::text('name', null,array('class'=>'form-control input-sm')) !!}<br>Key: <span class="exkey"></span>{{$field->id.$field->type}}</td>
                    <td width="60%">
                        {!! Form::textarea('settings', null,array('class'=>'form-control input-sm','style'=>'height:100px')) !!}
                    </td>
                    <td width="10%">
                        <a href="#" id="{{ $field->id }}" class="up"><span class="glyphicon glyphicon-chevron-up"></span></a>
                        <a href="#" onclick="$(this).parents('form').submit();return false"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></a><br>

                        <a href="#" id="{{ $field->id }}" class="down"><span class="glyphicon glyphicon-chevron-down"></span></a>
                        <a href="#" onclick="$('.form{{ $field->id }}').submit();return false"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    </td>

                </tr>
            </table>
            {!! Form::close() !!}
            {!! Form::open(array('route' => array('field.destroy', $field->id), 'method' => 'delete','class'=>'form'.$field->id)) !!}{!! Form::close()  !!}

        @empty
            <div>Keine Option gefunden</div>

        @endforelse
    </div>
    {!! Form::open(array('url' => 'field', 'method' => 'post')) !!}
    <table class="table table-striped nomargin">
        <tr>
            <td colspan="4"><b>Neues Element:</b></td>
        </tr>
        <tr>
            {!! Form::hidden('element_id', $element->id) !!}
            <td width="30%" style="border: 0;">{!! Form::text('name', null,array('class'=>'form-control input-sm')) !!}{!! Form::hidden('type', mt_rand(10,99)) !!}</td>
            <td width="60%" style="border: 0;">{!! Form::textarea('settings', null,array('class'=>'form-control input-sm','style'=>'height:100px')) !!}</td>
            <td width="10%" style="border: 0;"> <a href="#" onclick="$(this).parents('form').submit();return false"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></a></td>

        </tr>
    </table>
    {!! Form::close() !!}



@endif
