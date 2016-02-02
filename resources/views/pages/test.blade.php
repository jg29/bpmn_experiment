<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <script src="/js/jquery.min.js"     type="text/javascript"></script>
    <script src="/js/jquery-ui.min.js"  type="text/javascript"></script>
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    <style type="text/css">
        html, body, #canvas, #canvas > div {
            height: 100%;
        }

    </style>
    <script>
        var pizzaDiagram = Array();
        @foreach($diagramme as $diagramm)
            pizzaDiagram.push('{!! str_replace("\n","",$diagramm->value) !!}');
        @endforeach


    </script>
    <!--
      this is an example of how to use bpmn-js in a standalone application built with
      CommonJS modules + browserify
    -->

    <title>npm/browserify example - bpmn-js-examples</title>
</head>
<body>

<h1>Pizza Collaboration Viewer</h1>
<div id="slider" style="width: 500px;margin-left: 100px;"></div>

<div id="canvas"></div>

<script src="viewer/dist/app.js"></script>
</body>
</html>