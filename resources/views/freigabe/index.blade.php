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


            $(".insert1").keyup(function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    $.ajax({
                        type: "POST",
                        url: "/freigabe/mail",
                        data: {
                            "mail":$(".insert1").val(),
                            "_token":$('form input[name=_token]').val()
                        },
                        success: function(json) {
                            if(json != "") {
                                console.log();
                                $(".insert1").parent().parent().parent().before("<tr><td>"+json.name+"</td><td>"+json.email+'</td><td><input type="hidden" name="recht[edit][]" value="'+json.id+'"><a onclick="$(this).parent().parent().remove();return false;" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>')
                                $(".insert1").parent().removeClass("has-error")
                            } else {
                                $(".insert1").parent().addClass("has-error")
                            }
                        }
                    });
                }, 1000)
            });
            $(".insert2").keyup(function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    $.ajax({
                        type: "POST",
                        url: "/freigabe/mail",
                        data: {
                            "mail":$(".insert2").val(),
                            "_token":$('form input[name=_token]').val()
                        },
                        success: function(json) {
                            if(json != "") {
                                console.log();
                                $(".insert2").parent().parent().parent().before("<tr><td>"+json.name+"</td><td>"+json.email+'</td><td><input type="hidden" name="recht[view][]" value="'+json.id+'"><a onclick="$(this).parent().parent().remove();return false;" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>')
                                $(".insert2").parent().removeClass("has-error")
                            } else {
                                $(".insert2").parent().addClass("has-error")
                            }
                        }
                    });
                }, 1000)
            });
        });

    </script>

@stop


@section('content')
    <div class="container">
        <div class="form">
            {!! Form::open(array('url' => '/freigabe/'.$experiment->id.'/save', 'method' => 'post', 'class'=>'orderxor')) !!}
            <h3>Editierung</h3>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th></th>
                </tr>

                @foreach($editUser as $user)
                    <tr>
                        <td>{{ $users[$user]->name }}</td>
                        <td>{{ $users[$user]->email }}</td>
                        <td><input type="hidden" name="recht[view][]" value="{{ $user }}"><a onclick="$(this).parent().parent().remove();return false;" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> </td>
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td><div>
                            <input type="text" class="insert1 form-control" />
                            </div>
                        </td>
                        <td></td>
                    </tr>
            </table>



            <h3>Auswertung</h3>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>E-Mail</th>
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




