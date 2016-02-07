@extends('app')

@section('head')

    <script src="/js/bpmn-js/dist/bpmn-viewer.js"></script>


    <style type="text/css">
        .canvas {
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: white;

        }
        #slider {
            margin-top: 20px;
            position: fixed;
            top: 40px;
            left: 25%;
            width: 50%;
            z-index: 100;
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

                                $('.alert-success').text((num+1)+" von "+(diagram.length)+" geladen");
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

@stop


@section('content')



<div id="slider" class="col-md-5"></div>
<div id="can"></div>
<div class="alert alert-success" role="alert"></div>

@stop
