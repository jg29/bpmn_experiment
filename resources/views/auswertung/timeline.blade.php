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
            display: none;
        }
        .row {
            margin-top: -10px;
        }
        #slider {
            margin-top: 5px;
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
        .forward {
            visibility: hidden;
        }
        .stop{
            display: none;
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
                            slideTo(ui.value);

                        },
                        stop: function() {

                        }

                    });
                    var timeId;
                    var timeNum;
                    $('.play').click(function() {
                        var timeFunc = function() {
                            timeNum = $( "#slider").slider('value');
                            slideTo(++timeNum % diagram.length);
                            timeId = window.setTimeout(timeFunc , 1000);
                        };
                        timeId = window.setTimeout(timeFunc , 1000);
                        $('.play').css('display', 'none');
                        $('.stop').css('display', 'inline-block');
                        return false;
                    });
                    $('.stop').click(function() {
                        clearTimeout(timeId);
                        $('.play').css('display', 'inline-block');
                        $('.stop').css('display', 'none');
                        return false;
                    });
                    $('.back').click(function() {
                        var to = $( "#slider").slider('value')-1;
                        slideTo(to);
                        return false;
                    });
                    $('.forward').click(function() {
                        var to = $( "#slider").slider('value')+1;
                        slideTo(to);
                        return false;
                    });

                });

        function slideTo(id) {
            if(0 <= id && id < diagram.length) {
                $( "#slider").slider('value', id);
                $('.canvas').css('visibility','hidden')
                $('.canvas'+id).css('visibility','visible')
                if(id == 0) {
                    $('.back').css('visibility','hidden')
                } else {
                    $('.back').css('visibility','visible')
                }
                if(id == diagram.length-1) {
                    $('.forward').css('visibility','hidden')
                } else {
                    $('.forward').css('visibility','visible')
                }
            }

        }

    </script>
    <!--
      this is an example of how to use bpmn-js in a standalone application built with
      CommonJS modules + browserify
    -->

@stop


@section('content')



<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8"><div id="slider"></div></div>
    <div class="col-md-1">
        <a href="#" class="back"> <span class="glyphicon glyphicon-backward"></span></a>
        <a href="#" class="play"> <span class="glyphicon glyphicon-play"></span></a>
        <a href="#" class="stop"> <span class="glyphicon glyphicon-stop"></span></a>
        <a href="#" class="forward"> <span class="glyphicon glyphicon-forward"></span></a>
    </div>
    <div class="col-md-1"></div>
</div>
<div id="can"></div>
<div class="alert alert-success" role="alert"></div>

@stop
