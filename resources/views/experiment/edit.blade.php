@extends('app')

@section('head')
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ @url('js/experiment.js') }}"></script>
    <link href="{{ @url('css/experiment.css') }}" rel="stylesheet">

@stop


@section('content')
    <div class="form">

        <h1>Bearbeite: {!! $experiment->title !!}</h1>

        {!! Form::model($experiment,array('url' => 'experiment/'.$experiment->id, 'method' => 'patch')) !!}
            @include('experiment.form',['submitButtonText'=>'Bearbeiten'])
        {!! Form::close() !!}

        @include('errors.list')
    </div>


    <div class="popup" style="display:none">
        Elementname:<br>
        <input type="text" style="width:100%;" class="title"><br><br>

        <textarea style="width:100%; height:300px;" class="text"></textarea>
        <input type="submit" value="Einf&uuml;gen" class="einfuegen">

    </div>


    <ul class="menu">
        <li typ="1" class="insert message"><div>Message</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
        <li typ="2" class="insert survey"><div>Survey</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
        <li typ="3" class="insert edit"><div>Modelierung</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
        <li typ="4" class="insert feedback"><div>Feedback</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>

<!--
        <li type="5" class="insert xor" id="xor">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td width="20%" style="background:url('{{ @url('img/XORl.png') }}');height:60px;">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORc.png') }}')">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORr.png') }}')">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20%" align="center">
                        <a class="add" href="#">+</a>
                    </td>
                    <td width="20%" align="center">
                        <a class="add" href="#">+</a>
                    </td>
                    <td width="20%" align="center">
                        <a class="add" href="#">+</a>
                    </td>
                </tr>
                <tr>
                    <td width="20%" style="background:url('{{ @url('img/XORll.png') }}');height:60px;">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORcc.png') }}')">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORrr.png') }}')">&nbsp;</td>
                </tr>
            </table>
            <img class="arrow" src="{{ @url('img/arrow.png') }}" />
        </li>
        -->
        <li typ="5" class="insert xor">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td width="20%" style="background:url('{{ @url('img/XORl.png') }}');height:60px;">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORm.png') }}')">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORc.png') }}')">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORm.png') }}')">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORr.png') }}')">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20%" align="center">
                        <a class="add" href="#">+</a>
                    </td>
                    <td width="20%" align="center">
                        <a class="add" href="#">+</a>
                    </td>
                    <td width="20%" align="center">
                        <a class="add" href="#">+</a>
                    </td>
                    <td width="20%" align="center">
                        <a class="add" href="#">+</a>
                    </td>
                    <td width="20%" align="center">
                        <a class="add" href="#">+</a>
                    </td>
                </tr>
                <tr>
                    <td width="20%" style="background:url('{{ @url('img/XORll.png') }}');height:60px;">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORmm.png') }}')">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORcc.png') }}')">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORmm.png') }}')">&nbsp;</td>
                    <td width="20%" style="background:url('{{ @url('img/XORrr.png') }}')">&nbsp;</td>
                </tr>
            </table>
            <img class="arrow" src="{{ @url('img/arrow.png') }}" />
        </li>
            </ul>

    <div class="wrapper">
        <ul class="canvas">
            <li class="start" id="start"><div>&nbsp;</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
            @if($element)
                <li id="{{$element->id }}" class="{{ $element->getClass() }}" ><div>{!! $element->title !!}</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>

                @while($element = $element->next())
                    <li id="{{$element->id }}" class="{{ $element->getClass() }}"><div>{!! $element->title !!}</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
                @endwhile

            @endif







            <li class="ende" id="ende"><div>&nbsp;</div></li>
        </ul>
    </div>

    {!! Form::open(array('url' => 'element', 'method' => 'post', 'class'=>'new')) !!}
        {!! Form::hidden('title') !!}
        {!! Form::hidden('type') !!}
    {!! Form::close() !!}

    {!! Form::open(array('url' => 'element', 'method' => 'post', 'class'=>'order')) !!}
    {!! Form::hidden('order') !!} {!! Form::hidden('experiment', $experiment->id) !!}
    {!! Form::close() !!}


    <div class="konsole"></div>

@stop

