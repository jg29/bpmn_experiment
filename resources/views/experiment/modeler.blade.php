@extends('app')

@section('content')

    <link rel="stylesheet" href="/modeler/dist/css/diagram-js.css" />
    <link rel="stylesheet" href="/modeler/dist/vendor/bpmn-font/css/bpmn-embedded.css" />
    <link rel="stylesheet" href="/modeler/app/css/app.css" />


    <div class="content"  id="#js-drop-zone">

        <div class="canvas" id="js-canvas"></div>

    </div>
    <script src="/modeler/dist/index2.js"></script>
    <textarea class="ergebniss" style=" display:none;position: fixed; top: 50px;left: 0px; right: 0px; bottom: 0px; width: 100%; height: 100%; z-index: 10000000;"></textarea>

    <a href="#" style="float: right;" class="btn-default btn">Diagramm kopieren</a>

@stop