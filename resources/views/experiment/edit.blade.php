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
        <li class="insert survey"><div>Survey</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
        <li class="insert xor" id="xor">
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
            <img class="arrow" src="arrow.png" />
        </li>
        <li class="insert xor">
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
            <img class="arrow" src="arrow.png" />
        </li>
        <li class="insert edit"><div>Modelierung</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
        <li class="insert feedback"><div>Feedback</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
        <li class="insert message"><div>Message</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
    </ul>

    <div class="wrapper">
        <ul class="canvas">
            <li class="start" id="start"><div>&nbsp;</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
            @if($element)
                <li id="element{{$element->id }}" class="{{ $element->getClass() }}" ><div>{!! $element->title !!}</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
            @endif
            @while($element = $element->next())
                <li id="element{{$element->id }} "class="{{ $element->getClass() }}"><div>{!! $element->title !!}</div><img class="arrow" src="{{ @url('img/arrow.png') }}" /></li>
            @endwhile






            <li class="ende" id="ende"><div>&nbsp;</div></li>
        </ul>
    </div>


    <div class="konsole"></div>

@stop

