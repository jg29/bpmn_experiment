function save() {
    $(".canvas").append($(".canvas .ende"));
    $(".canvas").prepend($(".canvas .start"))
    var wert = '';
    $('.canvas > li').each(function () {
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
        success: function() {

        }
    });
    if($('.canvas .xor').length == 0) {
        $('.menu .xor').css('display','')

    } else {
        $('.menu .xor').css('display','none')
    }

}
function sidebar(id) {

    $.ajax({
        type: "GET",
        url: '/element/'+id+'/edit',
        success: function(msg) {
            $('.sidepanel').html(msg);
            $('.exkey').text($('.canvas').attr('key')+'-')

            $('.sidepanel .up').click(function() {
                $.ajax({
                    type: "GET",
                    url: '/field/up',
                    data: { id: $(this).attr('id'), eid:id},
                    success: function(msg){
                        sidebar(id);
                        if($('#'+id).hasClass('xor')) {
                            window.location.reload();
                        }
                    }
                });
                return false;
            });
            $('.sidepanel .down').click(function() {
                $.ajax({
                    type: "GET",
                    url: '/field/down',
                    data: { id: $(this).attr('id'), eid:id},
                    success: function(msg){
                        sidebar(id);
                        if($('#'+id).hasClass('xor')) {
                            window.location.reload();
                        }
                    }
                });
                return false;
            });
            $('.sidepanel form').submit(function() {
                var $data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: $data,
                    success: function(msg){
                        $('#'+id+' div').text($('.element'+id+' input[name=title]').val());
                        sidebar(id);
                        if($('#'+id).hasClass('xor')) {
                            window.location.reload();
                        }
                    }
                });
                return false;
            })
            $('.element'+id+' .delete').click(function() {
                $('#'+id).remove();
                save();
            })
        }
    });
}

$(function() {
    if($('.canvas .xor').length == 0) {
        $('.menu .xor').css('display','')

    } else {
        $('.menu .xor').css('display','none')
    }
    var $copy;
    var sort = {
        revert: true,
        start: function() {
            $(".arrow").css("visibility","hidden")
        },
        stop: function() {
            $(".arrow").css("visibility","");
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
            if (id == 5) {
                var name = 'XOR';
                $copy.find('div').html('<hr><span><p style="background-color:#d9534f;color: white">bitte Bearbeiten</p></span><hr>')
            } else{
                var name = prompt("Bitte Name eingeben:");
                $copy.find('div').text(name);
            }

            $('.new input[name=title]').val(name);
            $('.new input[name=type]').val(id);

            var data = $(".new").serialize();
            $.ajax({
                type: "POST",
                url: $('.new').attr('action'),
                data: data,
                success: function(msg){
                    $copy.attr('id', msg);
                    $copy.css('height','');
                    save();
                }
            });
            $copy.click(function() {
                var id = $(this).attr('id')
                sidebar(id)
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
        }
    };
    $( ".canvas" ).sortable(sort);
    $( ".canvas li" ).click(function() {
        var id = $(this).attr('id')
        sidebar(id)
    });
    $( ".insert" ).draggable(drag);
    $( "ul, li" ).disableSelection();

});