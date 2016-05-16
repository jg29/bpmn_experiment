@extends('app')

@section('head')
    <script>

        $(function() {
            $('option').mousedown(function(e) {
                e.preventDefault();
                $(this).prop('selected', $(this).prop('selected') ? false : true);
                return false;
            });


            var timer;
            var num = 1;
            $(".insert"+num).keyup(function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    $.ajax({
                        type: "POST",
                        url: "/freigabe/mail",
                        data: {
                            "mail":$(".insert"+num).val(),
                            "_token":$('form input[name=_token]').val()
                        },
                        success: function(json) {
                            var elemente = new Array();
                            $('.edit input[type=hidden]').each(function() {
                                elemente.push($(this).val());
                            });

                            if(json == "error_selbst") {
                                $(".insert"+num).parent().removeClass("has-warning");
                                $(".insert"+num).parent().addClass("has-error")
                                $(".text"+num).html("Sie können sich nicht selber hinzufügen.")
                            } else if(json == "error_recht") {
                                $(".insert"+num).parent().removeClass("has-warning");
                                $(".insert"+num).parent().addClass("has-error")
                                $(".text"+num).html("Der Nutzer hat nicht die nötige Berechtigung.")
                            } else if(json == "") {
                                $(".insert"+num).parent().removeClass("has-warning");
                                $(".insert"+num).parent().addClass("has-error")
                                $(".text"+num).html("Benutzer wurde nicht gefunden!")
                            } else {
                                if(!$.inArray(json.id, elemente)) {
                                    if(num == 1) {
                                        $(".insert"+num).parent().parent().parent().before("<tr><td>"+json.name+"</td><td>"+json.email+'</td><td><input type="hidden" name="recht[edit][]" value="'+json.id+'"><a onclick="$(this).parent().parent().remove();return false;" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>')
                                    } else {
                                        $(".insert"+num).parent().parent().parent().before("<tr><td>"+json.name+"</td><td>"+json.email+'</td><td><input type="hidden" name="recht[view][]" value="'+json.id+'"><a onclick="$(this).parent().parent().remove();return false;" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>')
                                    }
                                    $(".insert"+num).parent().removeClass("has-error");
                                    $(".insert"+num).parent().removeClass("has-warning");
                                    $(".text"+num).html("")
                                } else {
                                    $(".text"+num).html("Benutzer bereits hinzugefügt.")
                                    $(".insert"+num).parent().removeClass("has-error");
                                    $(".insert"+num).parent().addClass("has-warning")
                                }
                            }
                        }
                    });
                }, 1000)
            });
            $(".insert1").keyup(function() {
                $(".text1").html("Suche läuft ...");
                $(".insert1").parent().removeClass("has-error");
                $(".insert1").parent().addClass("has-info");
                clearTimeout(timer);
                timer = setTimeout(function() {
                    timeFunc(1);
                }, 1000)
            });
            $(".insert2").keyup(function() {
                $(".text2").html("Suche läuft ...");
                $(".insert2").parent().removeClass("has-error");
                $(".insert2").parent().addClass("has-info");
                clearTimeout(timer);
                timer = setTimeout(function() {
                    timeFunc(2);
                }, 1000)
            });

        });




        function timeFunc(num) {
            if($(".insert"+num).val() == "") {

                $(".text"+num).html("");
                $(".insert"+num).parent().removeClass("has-error");
                $(".insert"+num).parent().removeClass("has-warning");

            } else {
                $.ajax({
                    type: "POST",
                    url: "/freigabe/mail",
                    data: {
                        "mail":$(".insert"+num).val(),
                        "_token":$('form input[name=_token]').val()
                    },
                    success: function(json) {
                        var elemente = new Array();
                        if(num == 1) {
                            $('.edit input[type=hidden]').each(function() {
                                elemente.push(parseInt($(this).val()));
                            });
                        } else {
                            $('.view input[type=hidden]').each(function() {
                                elemente.push(parseInt($(this).val()));
                            });
                        }

                        if(json == "error_selbst") {
                            $(".insert"+num).parent().removeClass("has-warning");
                            $(".insert"+num).parent().addClass("has-error")
                            $(".text"+num).html("Sie können sich nicht selber hinzufügen.")
                        } else if(json == "error_recht") {
                            $(".insert"+num).parent().removeClass("has-warning");
                            $(".insert"+num).parent().addClass("has-error")
                            $(".text"+num).html("Der Nutzer hat nicht die nötige Berechtigung.")
                        } else if(json == "") {
                            $(".insert"+num).parent().removeClass("has-warning");
                            $(".insert"+num).parent().addClass("has-error")
                            $(".text"+num).html("Benutzer wurde nicht gefunden!")
                        } else {
                            if($.inArray(json.id, elemente) == -1) {
                                if(num == 1) {
                                    $(".insert"+num).parent().parent().parent().before("<tr><td>"+json.name+"</td><td>"+json.email+'</td><td><input type="hidden" name="recht[edit][]" value="'+json.id+'"><a onclick="$(this).parent().parent().remove();return false;" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>')
                                } else {
                                    $(".insert"+num).parent().parent().parent().before("<tr><td>"+json.name+"</td><td>"+json.email+'</td><td><input type="hidden" name="recht[view][]" value="'+json.id+'"><a onclick="$(this).parent().parent().remove();return false;" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>')
                                }
                                $(".insert"+num).val("");
                                $(".insert"+num).parent().removeClass("has-error");
                                $(".insert"+num).parent().removeClass("has-warning");
                                $(".text"+num).html("")
                            } else {
                                $(".text"+num).html("Benutzer bereits hinzugefügt.")
                                $(".insert"+num).parent().removeClass("has-error");
                                $(".insert"+num).parent().addClass("has-warning")
                            }
                        }
                    }
                });
            }

        }

    </script>

@stop


@section('content')
    <div class="container">
        <div class="form">
            {!! Form::open(array('url' => '/freigabe/'.$experiment->id.'/save', 'method' => 'post', 'class'=>'orderxor')) !!}
            <h3>Editierung</h3>
            <table class="edit table table-striped">
                <tr>
                    <th width="30%">Name</th>
                    <th width="60%">E-Mail</th>
                    <th></th>
                </tr>

                @foreach($editUser as $user)
                    <tr>
                        <td>{{ $users[$user]->name }}</td>
                        <td>{{ $users[$user]->email }}</td>
                        <td><input type="hidden" name="recht[edit][]" value="{{ $user }}"><a onclick="$(this).parent().parent().remove();return false;" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> </td>
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td><div>
                                <input type="text" class="insert1 form-control" />
                                <span class="help-block text1"></span>
                            </div>
                        </td>
                        <td></td>
                    </tr>
            </table>



            <h3>Auswertung</h3>
            <table class="view table table-striped">
                <tr>
                    <th width="30%">Name</th>
                    <th width="60%">E-Mail</th>
                    <th></th>
                </tr>

                @foreach($viewUser as $user)
                    <tr>
                        <td>{{ $users[$user]->name }}</td>
                        <td>{{ $users[$user]->email }}</td>
                        <td><input type="hidden" name="recht[view][]" value="{{ $user }}"><a onclick="$(this).parent().parent().remove();return false;" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td><div>
                            <input type="text" class="insert2 form-control" />
                            <span class="help-block text2"></span>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>

            {!! Form::submit('Speichern', array('class'=>'btn btn-default')) !!}


            {!! Form::close() !!}
        </div>

    </div>

@stop




