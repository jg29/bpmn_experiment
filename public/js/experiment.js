
function ordering() {
    $(".canvas").append($(".canvas .ende"));
    $(".canvas").prepend($(".canvas .start"))

}

function save() {
    var text = $('.konsole').html();
    var wert = '';

    $('.canvas > li').each(function () {
        text += $(this).attr("id")+" -> ";
        if($(this).attr("id") != undefined && $(this).attr("id")!= 'start' && $(this).attr("id") != 'ende'){
            wert+=$(this).attr("id")+',';
        }

    });

    $('.order input[name=order]').val(wert);
    var data = $(".order").serialize();


    $.ajax({
        type: "POST",
        url: $('.order').attr('action'),
        data: data,
        success: function(msg){
   //         alert( msg );
        }
    });

    text += "<br>";


    $('.konsole').html(text);

}

$(function() {
    var $copy;
    var sort = {
        revert: true,
        start: function() {
            $(".arrow").css("visibility","hidden")
        },
        stop: function() {
            $(".arrow").css("visibility","");
            ordering();
            save();
        },
    };
    var drag = {
        connectToSortable: ".canvas, .can",
        helper: function () {
            $copy = $(this).clone();
            return $copy;
        },
        revert: "invalid",
        start: function() {

            $copy.css("width","auto")

        },
        stop: function(){
            $copy.css("width","auto")

            var id = $(this).attr('typ')
            var name = prompt("Bitte Name eingeben:");
            $copy.find('div').text(name);
            $('.new input[name=title]').val(name);
            $('.new input[name=type]').val(id);

            var data = $(".new").serialize();
            $.ajax({
                type: "POST",
                url: $('.new').attr('action'),
                data: data,
                success: function(msg){
                    $copy.attr('id', msg)
                    ordering();
                    save();
                }
            });

            $('.add').click(function() {
                $(".popup").fadeIn(100);
                var self = $(this);
                $(".einfuegen").click(function() {
                    $(".einfuegen").unbind('click')
                    self.parent().append("<span>"+$(".title").val()+"</span>");
                    $(".popup .title").val("");
                    $(".popup .text").val("");
                    $(".popup").fadeOut(100);
                    self.css("display","none")
                });
                return false;
            });
            ordering();
        }
    };
    var sidebar = function () {
        //alert($(this).attr('id'))

        $.ajax({
            type: "GET",
            url: 'element/'+$(this).attr('id')+'/edit',
            success: function(msg) {
                $('.sidepanel').html(msg);
            }
        });


    }

    $( ".canvas" ).sortable(sort);
    $( ".canvas li" ).click(sidebar);

    $( ".insert" ).draggable(drag);
    $( "ul, li" ).disableSelection();



});