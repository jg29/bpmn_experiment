
(function () {
  'use strict';
}());

var BpmnModeler = require('bpmn-js/lib/Modeler');
var container = $('#js-drop-zone');
var canvas = $('#js-canvas');
var renderer = new BpmnModeler({ container: canvas });

var bpmnxml = '';



function openDiagram(xml) {

  renderer.importXML(xml, function(err) {

    if (err) {
      container
          .removeClass('with-diagram')
          .addClass('with-error');

      container.find('.error pre').text(err.message);

      console.error(err);
    } else {
        container
            .removeClass('with-error')
            .addClass('with-diagram');
        var eventBus = renderer.get('eventBus');

        var events = [
            'element.hover',
            'element.out',
            'element.click',
            'element.dblclick',
            'element.mousedown',
            'element.mouseup'
        ];

        events.forEach(function (event) {

            eventBus.on(event, function (e) {
                saveDiagram(function (err, xml) {
                    if (bpmnxml != xml) {
                        bpmnxml = xml;

                        $.ajax({
                            type: "POST",
                            url: "/experiment/"+$('.content').attr('experiment')+"/"+$('.content').attr('element')+"/draw",
                            data: { draw: bpmnxml, "_token": $('.token input[name=_token]').val()},
                            success: function(msg){
                                console.log(msg);
                            }
                        });
                    }
                });
                /*saveSVG(function(err, svg) {
                    alert(svg);
                    setEncoded($('#js-download-svg'), 'diagram.svg', err ? null : svg);
                });*/

            });
        });
    }
  });

}


function saveDiagram(done) {

  renderer.saveXML({ format: true }, function(err, xml) {
    done(err, xml);
  });
}

function saveSVG(done) {
    renderer.saveSVG(done);
}
// bootstrap diagram functions

var seitenwechsel = true;
$(document).on('ready', function() {
  $.ajax({
    url: "/modeler/resources/old.bpmn",
    cache: false
  }).done(function( data ) {
      openDiagram(data);
  });


    window.onbeforeunload = function () {
        if(seitenwechsel)   {
            return 'Möchten Sie die Seite wirklich verlassen?';
        }
    };
    $('.btn-default').click(function() {
        seitenwechsel = false;



        saveSVG(function(err, svg) {
            $.ajax({
                type: "POST",
                url: "/experiment/"+$('.content').attr('experiment')+"/"+$('.content').attr('element')+"/svg",
                data: { draw: svg, "_token": $('.token input[name=_token]').val()},
                success: function(msg){
                    console.log(msg);
                }
            });
        });

    });


});