
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
                        console.log('geaendert');
                    }

                });

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

// bootstrap diagram functions

$(document).on('ready', function() {
  $.ajax({
    url: "/modeler/resources/old.bpmn",
    cache: false
  }).done(function( data ) {
      openDiagram(data);
  });


});