
(function () {
  'use strict';
}());

// we use fs + brfs to inline an example XML document.
// exclude fs in package.json#browser + use the brfs transform
// to generate a clean browserified bundle
var fs = require('fs');
var BpmnViewer = require('bpmn-js');

$(function() {
  // inlined in result file via brfs
  var viewer = new BpmnViewer({ container: '#canvas' });

  $( "#slider" ).slider({
    value:0,
    min: 0,
    max: pizzaDiagram.length-1,
    step: 1,
    slide: function( event, ui ) {
      var num = (window.location.hash.replace('#', ''));
      viewer.importXML(pizzaDiagram[ui.value], function(err) {

        if (!err) {
          console.log('success!');
          viewer.get('canvas').zoom('fit-viewport');
        } else {
          console.log('something went wrong:', err);
        }
      });


      //$( "#amount" ).val( "$" + ui.value );
    }
  });



  $(window).on('hashchange',function(){


  });



});

