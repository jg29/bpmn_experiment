@extends('app')

@section('head')
    <script src="{{ @url('js/experiment.js') }}"></script>
    <link href="{{ @url('css/experiment.css') }}" rel="stylesheet">

@stop


@section('content')




    <div class="popup" style="display:none">
        Elementname:<br>
        <input type="text" style="width:100%;" class="title"><br><br>

        <textarea style="width:100%; height:300px;" class="text"></textarea>
        <input type="submit" value="Einf&uuml;gen" class="einfuegen">

    </div>


    <div class="row">

        <div class="col-md-1">
            <ul class="menu">
                <li typ="1" class="insert message"><div>Message</div></li>
                <li typ="2" class="insert survey"><div>Survey</div></li>
                <li typ="3" class="insert edit"><div>Model</div></li>
                <li typ="4" class="insert feedback"><div>Feedback</div></li>
                <li typ="5" class="insert xor" ><div class="num1"><span><p>XOR</p></span></div>
                </li>
            </ul>
        </div>
        <div class="col-md-6 main">
            <h3>Bearbeite: {!! $experiment->title !!}<small> <a href="#" onclick="$('.form').toggle(200); return false"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></small></h3>



            <div class="form container" style="display: none;">
{!! Form::model($experiment ,array('url' => 'experiment/'.$experiment->id, 'method' => 'patch','class'=>'form-horizontal')) !!}
                @include('experiment.form',['submitButtonText'=>'Bearbeiten'])
                {!! Form::close() !!}

                @include('errors.list')
            </div>
                <ul class="canvas">
                    <li class="start" id="start"><div>&nbsp;</div></li>
                    @if($element)
                        <li id="{{$element->id }}" class="{{ $element->getClass() }}" ><div>{!! $element->title !!}</div></li>

                        @while($element = $element->next())
                            @if($element->type == 5)
                                <li id="{{$element->id }}" class="{{ $element->getClass() }}">
                                    <hr>
                                    @if(count($element->fields) == 0)
                                        <div class="num3">
                                            <span><p style="background-color:white;">leer</p></span>
                                        </div>
                                    @else
                                        <div class="num{{count($element->fields)}}">
                                            @foreach($element->fields as $field)
                                                <span><p>{{$field->name}}</p></span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <hr>
                                </li>
                            @else
                                <li id="{{$element->id }}" class="{{ $element->getClass() }}"><div>{!! $element->title !!}</div></li>


                            @endif
                        @endwhile

                    @endif
                    <li class="ende" id="ende"><div>&nbsp;</div></li>
                </ul>

        </div>
        <div class="col-md-5 sidepanel">
            kein Element ausgewählt






        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><div class="konsole"></div></div>

    </div>




    {!! Form::open(array('url' => 'element', 'method' => 'post', 'class'=>'new')) !!}
        {!! Form::hidden('title') !!}
        {!! Form::hidden('type') !!}
    {!! Form::close() !!}

    {!! Form::open(array('url' => 'element/order', 'method' => 'post', 'class'=>'order')) !!}
    {!! Form::hidden('order') !!} {!! Form::hidden('experiment', $experiment->id) !!}
    {!! Form::close() !!}




@stop

