<html>
<head>
    <title>bpmn-js modeler demo</title>
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="/modeler/dist/css/diagram-js.css" />
    <link rel="stylesheet" href="/modeler/dist/vendor/bpmn-font/css/bpmn-embedded.css" />
    <link rel="stylesheet" href="/modeler/dist/css/app.css" />
</head>
<body>
<div class="content" id="js-drop-zone">



    <div class="message error">
        <div class="note">
            <p>Ooops, we could not display the BPMN 2.0 diagram.</p>

            <div class="details">
                <span>cause of the problem</span>
                <pre></pre>
            </div>
        </div>
    </div>

    <div class="canvas" id="js-canvas"></div>
</div>



<script src="modeler/dist/index.js"></script>
</html>
