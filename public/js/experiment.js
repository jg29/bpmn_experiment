function save() {
    $(".canvas").append($(".canvas .ende"));
    $(".canvas").prepend($(".canvas .start"))
    var wert = '';
    $('.canvas > li').each(function () {
        if($(this).attr("id") != undefined && $(this).attr("id")!= 'start' && $(this).attr("id") != 'ende'){
            wert+=$(this).attr("id")+',';
        }
    });
    var xorElement = new Array();

    $('.canvas > li ul').each(function () {
        var uid = $(this).attr('uid')
        var i = 0;
        xorElement[uid] = new Array();
        $(this).find('li').each(function () {
            if($(this).attr("id") != undefined && $(this).attr("id")!= 'start' && $(this).attr("id") != 'ende'){
                xorElement[uid][i++] = $(this).attr("id");
            }
        });
    });
    console.log(xorElement)

    if(wert !=$('.order input[name=order]').val()) {
        $('.order input[name=order]').val(wert);
        var data = $(".order").serialize();
        $.ajax({
            type: "POST",
            url: $('.order').attr('action'),
            data: data,
            success: function() {

            }
        });
    }
    var temp = new Array();
    if(temp != xorElement) {
        temp = xorElement;
        $('.order input[name=orderxor]').val(wert);
        $.ajax({
            type: "POST",
            url: $('.orderxor').attr('action'),
            data: {
                'element': $('.canvas .xor').attr('id'),
                '_token': $('.orderxor input[name=_token]').val(),
                'array': xorElement
            },
            success: function(msg) {
                console.log(msg)
            }
        });

    }

        if($('.canvas .xor').length == 0) {
        $('.menu .xor').css('display','')

    } else {
        $('.menu .xor').css('display','none')
    }
    $('.alert').html("gespeichert");
    $('.alert').fadeIn(500).delay(1000).fadeOut(500)
}
function sidebar(id) {

    $.ajax({
        type: "GET",
        url: '/element/'+id+'/edit',
        success: function(msg) {


            $('.sidepanel').html(msg);
            $('.numbermin').change(function() {
                var length = 0;
                $('.xor ul').each(function() {
                    if($(this).html().trim()) {
                        length++;
                    }
                });
                if($('.numbermin').val() < length) {
                    console.log('fehler');
                    $('.numbermin').val(length)
                    $(this).parent().find('.formfehler').text('Alle xOR-Pfade enthalten Elemente')
                }
            });
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
                        $('.alert').html("gespeichert");
                        $('.alert').fadeIn(500).delay(1000).fadeOut(500)
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
                $('.sidepanel').html("kein Element ausgewählt ");
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
        connectToSortable: ".canvas, .can, .canvas ul",
        helper: function () {
            $copy = $(this).clone();
            return $copy;
        },
        revert: "invalid",
        start: function() {
            $copy.css("width","auto")

        },
        drag: function() {
            $('.ui-sortable-placeholder').css({'visibility':'visible',opacity: 0.1});
            $('.ui-sortable-placeholder').html('<div></div>')
        },
        stop: function(){
            $copy.css("width","auto")

            var id = $(this).attr('typ')
            if (id == 5) {
                var name = 'XOR';
                $copy.find('div').html('<hr><ul><li style="background-color:#d9534f;color: white">bitte Bearbeiten</li></ul><hr>')
            } else{
                //var name = prompt("Bitte Name eingeben:");
                var name = "";
                $copy.find('div').html(name);

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

                    sidebar(msg)

                }
            });
            $copy.click(function() {
                var id = $(this).attr('id')
                sidebar(id)
            });

        }
    };
    $(".canvas, .canvas ul").sortable(sort);
    $(".canvas li, .canvas .xor li").not('.xor').click(function() {
        var id = $(this).attr('id')
        sidebar(id)
    });
    $(".canvas .xor .xorraute").click(function() {
        var id = $(this).parent().parent().attr('id')
        sidebar(id)
    });
    $(".insert").draggable(drag);
    $("ul, li").disableSelection();

});