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
                <li typ="5" class="insert xor" ><div class="num0"><span class="xorraute">XOR</span>
                        <hr><ul class="ui-sortable" uid="0"></ul><hr></div></li>
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
                <ul class="canvas" key="{{ $experiment->key }}">

                    <li class="start" id="start"><div>&nbsp;</div></li>
                    @while($element != null)
                        @if($element->type == \App\Element::XORGATE)
                            <li id="{{$element->id }}" class="{{ $element->getClass() }}">
                                @if($element->content == 0)
                                    <div class="num{{$element->content}}">
                                        <span class="xorraute">XOR</span>
                                        <hr>Bitte Pfadanzahl einstellen
                                        <ul class="ui-sortable" uid="0"></ul>
                                        <hr>
                                    </div>
                                @else
                                    <div class="num{{$element->content}}">
                                        <span class="xorraute">XOR</span>
                                        <hr>
                                        @foreach($element->getRef() as $ul)
                                            <ul uid="{{ $i++ }}">
                                                @foreach($ul as $li)
                                                    <li id="{{$li->id}}" class="{{ $li->getClass() }}"><div>{{$li->title  }}</div></li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                        @for($j = count($element->getRef()); $j < $element->content; $j++)
                                            <ul uid="{{  $j }}"></ul>
                                        @endfor
                                        <hr>
                                    </div>
                                @endif

                            </li>
                        @else
                            <li id="{{$element->id }}" class="{{ $element->getClass() }}"><div>{!! $element->title !!}</div></li>


                        @endif
                        <?php $element = $element->next(); ?>
                    @endwhile
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

    {!! Form::open(array('url' => 'element/orderxor', 'method' => 'post', 'class'=>'orderxor')) !!}
    {!! Form::hidden('experiment', $experiment->id) !!}
    {!! Form::close() !!}


    <div class="alert alert-success" role="alert">
        <a href="#" class="alert-link">...</a>
    </div>

@stop