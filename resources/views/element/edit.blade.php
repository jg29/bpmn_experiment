
{!! Form::model($element, array('url' => 'element/'.$element->id, 'method' => 'patch', 'class'=>'element'.$element->id.' form-horizontal','style'=>'margin-top:20px;')) !!}
@if($element->type != App\Element::XORGATE)
    <div class="form-group">
        {!! Form::label('title', 'Titel:',array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9"  style="padding-bottom: 5px;">
            {!! Form::text('title', null,array('class'=>'form-control')) !!}
        </div>
</div>
    @endif
    <div class="form-group">
        @if($element->type ==  App\Element::XORGATE)
            {!! Form::label('content', 'XOR-Pfade:', array('class'=>'col-sm-3 control-label')) !!}
            <div class="col-sm-9"  style="padding-bottom: 5px;">
            {!! Form::input('number', 'content', null , array('class'=>'form-control numbermin', 'min'=>"1", 'max'=>"6")) !!}
                <small class="formfehler"></small>
            </div>
        @else
            {!! Form::label('content', 'Erklärungstext:', array('class'=>'col-sm-3 control-label')) !!}
            <div class="col-sm-9"  style="padding-bottom: 5px;">
                {!! Form::textarea('content', null, array('class'=>'form-control')) !!}
            </div>
        @endif

    </div>


@if($element->type == App\Element::MODEL)
    <div class="form-group">
    {!! Form::label('content', 'BPMN vordefiniert (Editor):', array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9"  style="padding-bottom: 5px;">
            {!! Form::textarea('ref', null,array('class'=>'form-control')) !!}
            </div>

    </div>

@endif

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            {!! Form::submit("Speichern", array('class'=>'btn btn-default')) !!}
            <input type="button" value="Löschen" class="delete btn btn-default">
        </div>
    </div>


{!! Form::close() !!}

<div>&nbsp;</div>

@if($element->type == App\Element::XORGATE)
    <h4>Schlüssel</h4>
    @for($i=0;$i<($element->content);$i++)
        Pfad {{ $i+1 }}: <span class="exkey"></span>{{ ($i).substr(md5(date("s", strtotime($element->created_at)).$i), -2) }}<br>
    @endfor
@endif



@if($element->type == App\Element::SURVAY)
    <table class="table table-striped nomargin">
        <thead>
            <tr>
                <th width="30%">Title</th>
                <th width="25%">Type</th>
                <th width="30%">Wert</th>
                <th width="5%"><abbr title="Pflichtfeld">P</abbr></th>
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
                    <td width="25%">{!! Form::select('type', array('1'=>'Textfeld','2'=>'Textarea', '3'=>'Select', '4'=>'Radio', '5'=>'Checkbox'),null,array('class'=>'form-control input-sm')) !!}</td>
                    <td width="30%">
                            @if($field->type == 1)

                            @elseif($field->type == 2)

                            @elseif($field->type == 3)
                                {!! Form::textarea('settings', null,array('class'=>'form-control input-sm settings','style'=>'height:100px')) !!}
                            @elseif($field->type == 4)
                                {!! Form::textarea('settings', null,array('class'=>'form-control input-sm settings','style'=>'height:100px')) !!}
                            @elseif($field->type == 5)
                                {!! Form::textarea('settings', null,array('class'=>'form-control input-sm settings','style'=>'height:100px')) !!}
                            @endif
                    </td>
                    <td width="5%">
                        @if($field->type != 5)
                            {!! Form::checkbox('validation','required') !!}
                        @endif
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
                <td width="25%" style="border: 0;">{!! Form::select('type', array('1'=>'Textfeld','2'=>'Textarea', '3'=>'Select', '4'=>'Radio', '5'=>'Checkbox'),null,array('class'=>'form-control input-sm')) !!}</td>
                <td width="30%" style="border: 0;">{!! Form::textarea('settings', null,array('class'=>'form-control input-sm','style'=>'height:100px; display:none')) !!}</td>
                <td width="5%">
                    {!! Form::checkbox('validation','required') !!}
                </td>
                <td width="10%" style="border: 0;"> <a href="#" onclick="$(this).parents('form').submit();return false"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></a></td>

            </tr>
        </table>
    {!! Form::close() !!}
@endif