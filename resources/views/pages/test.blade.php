<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <link  href="/css/bootstrap.min.css" rel="stylesheet" media="all" />
    <script src="/js/jquery.min.js"     type="text/javascript"></script>
    <script src="/js/jquery-ui.min.js"  type="text/javascript"></script>
    <script src="/js/bpmn-js/dist/bpmn-viewer.js"></script>

    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    <style type="text/css">
        .canvas {
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: white;

        }
        #slider {
            margin-top: 20px;
            position: fixed;
            top: 0;
            left: 25%;
            width: 50%;
            display: none;

        }


        .alert{
            margin-left: -100px;
            padding: 15px;
            position: fixed;
            top: 45%;
            text-align: center;
            margin-top: -20px;
            left: 50%;
            width: 200px;
            z-index: 2000;
            -webkit-box-shadow: 0px 0px 50px 5px rgba(255,255,255,1);
            -moz-box-shadow: 0px 0px 50px 5px rgba(255,255,255,1);
            box-shadow: 0px 0px 50px 5px rgba(255,255,255,1);
        }
    </style>
    <script>
        var diagram = Array();
        @foreach($diagramme as $diagramm)
            diagram.push('{!! str_replace("\n","",$diagramm->value) !!}');
        @endforeach
                   $(function() {
                    var BpmnViewer = window.BpmnJS;
                    // var viewer = new BpmnViewer({ container: $('#js-canvas'), height: 600 });

                    function load(num) {
                        $('#can').append("<div class='canvas canvas"+num+"'></div>")
                        var viewer = new BpmnViewer({ container: '.canvas'+num });
                        viewer.importXML(diagram[num], function (err) {
                            if (err) {
                                console.log('something went wrong:', err);
                            } else {
                                viewer.get('canvas').zoom('fit-viewport');

                                $('.alert-success').text(num+" von "+(diagram.length-1)+" geladen");
                                if(num<diagram.length-1){
                                    load(num+1)
                                } else {

                                    $('.alert-success').delay(500).fadeOut(500);
                                    $('#slider').fadeIn(500);
                                }

                            }
                        });


                    }
                    load(0);

                    $('.canvas'+(diagram.length-1)).css('visibility','visible');

                    $( "#slider" ).slider({
                        value:diagram.length-1,
                        min: 0,
                        max: diagram.length-1,
                        step: 1,
                        slide: function( event, ui ) {

                            $('.canvas').css('visibility','hidden')
                            $('.canvas'+ui.value).css('visibility','visible')


                        },
                        stop: function() {

                        }

                    });



                });

    </script>
    <!--
      this is an example of how to use bpmn-js in a standalone application built with
      CommonJS modules + browserify
    -->

    <title>npm/browserify example - bpmn-js-examples</title>
</head>
<body>

        <div id="slider" class="col-md-5"></div>
<div id="can"></div>

<div class="alert alert-success" role="alert"></div>

</body>
</html>

