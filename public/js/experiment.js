
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
            $('.add').click(function() {
                $(".popup").fadeIn(100);
                var self = $(this);
                $(".einfuegen").click(function() {
                    $(".einfuegen").unbind('click')
                    self.parent().append("<span>"+$(".title").val()+"</span>");
                    $(".title").val("");
                    $(".text").val("");
                    $(".popup").fadeOut(100);
                    self.css("display","none")
                });
                return false;
            });
            ordering();
        }
    };
    function ordering() {
        $(".canvas").append($(".canvas .ende"));
        $(".canvas").prepend($(".canvas .start"))

    }

    function save() {
        var text = $('.konsole').html();


        $('.canvas > li').each(function () {
            text += $(this).attr("id")+" -> ";
        });

        text += "<br>";


        $('.konsole').html(text);

    }

    $( ".canvas" ).sortable(sort);
    $( ".insert" ).draggable(drag);
    $( "ul, li" ).disableSelection();



});