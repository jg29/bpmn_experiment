@extends('app')

@section('head')
    <script>
        $(function() {

            var numrows = $(".datatable thead tr:first-of-type th").length-1;

            var table = $('.datatable').DataTable({

                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;

                    api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== $(rows).eq( i).find(".header").html().trim() ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><th colspan="'+numrows+'">'+group+'</th><td><table><tr>'+$(rows).eq( i).find(".header").html().trim()+'</tr></table></td></tr>'
                            );
                            last = $(rows).eq( i).find(".header").html().trim();
                       }
                    } );
                },
                'scrollX': true,
                'scrollY': 'calc(100vh - 143px)',
                "paging":   false,
                "info":     false
            });

            var top = $('.dataTables_scrollBody .group').offset().top

            $('.dataTables_scrollBody').scroll(function() {
                $('.dataTables_scrollBody .group').each(function() {
                    if($(this).offset().top-top < 3) {
                        //console.log($(this).offset().top-top);
                        //$('.dataTables_scrollHead .group th:first-of-type').html($(this).find('th:first-of-type').html());
                        $('.dataTables_scrollHead .group table').html($(this).find('table').html());

                    }

                });
            });

            $('.right').hover(function(event) {
                var scrollTo = ($('.dataTables_scrollBody table').width()-$('.dataTables_scrollBody').scrollLeft()-$('.dataTables_scrollBody').width())
                var fehlt = $('.dataTables_scrollBody table').width()-$('.dataTables_scrollBody').width()
                $('.dataTables_scrollBody').animate({scrollLeft: fehlt}, scrollTo);
            },function() {
                $('.dataTables_scrollBody').stop();
            });
            $('.left').hover(function(event) {

                $('.dataTables_scrollBody').animate({scrollLeft: 0}, $('.dataTables_scrollBody').scrollLeft());
            },function() {
                $('.dataTables_scrollBody').stop();
            });




        });
    </script>
    <style>
        h3 {
            height: 0px;

        }

        div.dataTables_wrapper {
            width: 100%;
            height: 500px;

        }
        .table {
            font-size: 12px;

        }
        .table td, .table th {
            padding: 5px !important;
        }
        .dataTables_scrollBody thead th {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }

        .table .group td {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }
        .table table tr:first-child {
            display: none;
        }
        .table table tr:last-child {
            display: block;
        }
        .table th table {
            margin: 0px !important;
        }
        .table th table th {
            margin: 0px !important;
            border: 0px;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }
        .container {
            top: 52px;
            bottom: 0;
            left: 30px;
            right: 30px;
            position: fixed;
            width: calc(100% - 60px);
            height: 100%;
            padding: 0px !important;

        }
        .left {
            top: 115px;
            bottom: 0;
            left: 0px;
            position: fixed;
            width: 30px;
            height: 100%;
            padding: 0px !important;
        }
        .right {
            top: 115px;
            bottom: 0;
            right: 0px;
            position: fixed;
            width: 30px;
            height: 100%;
            padding: 0px !important;

        }
        table table tr {
            background: transparent !important;
        }
        .bjs-powered-by {
            margin-bottom: -20px;
            margin-right: -20px;

        }
        .bjs-powered-by img{
            height: 30px;
            width: 30px;

        }


    </style>
@stop


@section('content')
    <div class="left"></div>
    <div class="container">
        <div>
            <h3>Auswertung: {{ $experiment->title }} - <a href="http://localhost/auswertung/excel/{{$experiment->id}}"><span class="glyphicon glyphicon-download-alt"></span> Excel</a></h3>

            <table class="table datatable table-striped table-bordered" width="100%">

                <thead>
                    <tr class="group">
                        <th>XOR-Pfad</th>
                        <th>ID</th>
                        @foreach($elements as $element)
                            @if(!is_array($element))
                                <th>{{ $element->title }}</th>
                            @endif
                        @endforeach
                        <th><table></table></th>
                    </tr>

                </thead>
                <tbody>

                    @foreach($antworten as $k => $student)
                        <tr>

                            <td> <div style="width: 75px"></div>Pfad {{ \App\Answer::getPfad($k)+1 }}</td>
                            <td> <div style="width: 25px"></div>{{ \App\User::generateUserId($k) }}</td>

                            @foreach($elements as $key => $element)
                                @if(!is_array($element))
                                    @if(array_key_exists($element->id, $student))
                                        @if($element->type == 3)
                                            <td>
                                                <div style="width: 400px"></div>
                                                <a href="/auswertung/timeline/{{  $element->id }}/{{$k}}">
                                                    <img src="/svg/{{ $experiment->id }}/{{  $e->id }}_{{$k}}.png" style="max-width:400px; max-height: 250px" />
                                                </a>
                                            </td>
                                        @elseif($element->type == 4)
                                            <td>
                                                <div style="width: 400px"></div>
                                                {{ json_decode($student[$element->id]->value,true)['feedback'] }}
                                            </td>
                                        @elseif($element->type == 2)
                                            <td>
                                                <div style="width: 400px"></div>
                                                @foreach(json_decode($student[$element->id]->value,true) as $field => $value)
                                                    @if($fields[$field]->type == 3 OR $fields[$field]->type == 4 or $fields[$field]->type == 5)
                                                        @if(array_key_exists($field, $fields))
                                                            <label style="width: 150px; white-space:normal">{{ $fields[$field]->name.":"}}</label>{{ \App\Field::getFieldAnswers($field, $value) }}<br>
                                                        @endif
                                                    @else
                                                        <label style="width: 150px; white-space:normal">{{ $fields[$field]->name.": " }}</label>{{ $value }}<br>
                                                    @endif
                                                @endforeach
                                            </td>
                                        @else
                                            <td>{{ $student[$element->id]->value }}</td>
                                        @endif
                                    @else
                                        <td></td>
                                    @endif
                                @endif
                            @endforeach
                            @foreach($elements as $key => $element)
                                @if(is_array($element))
                                    <td>
                                        <table class="">
                                            <tr class="header">
                                                @if(count($element) != 0)
                                                    @if(array_key_exists(\App\Answer::getPfad($k), $element))
                                                        @foreach($element[\App\Answer::getPfad($k)] as $e)

                                                            <th><div style="width: 400px"></div>{{ $e->title }}</th>
                                                        @endforeach
                                                    @else
                                                        <th><div style="width: 400px"></div>keine Element</th>
                                                    @endif
                                                @endif
                                            </tr>
                                                <tr>
                                                @if(array_key_exists(\App\Answer::getPfad($k), $element))
                                                @foreach($element[\App\Answer::getPfad($k)] as $e)


                                                        @if(array_key_exists($e->id, $student))
                                                            @if($e->type == 3)
                                                                <td>
                                                                    <div style="width: 400px"></div>
                                                                    <a href="/auswertung/timeline/{{  $e->id }}/{{$k}}">
                                                                        <img src="/svg/{{ $experiment->id }}/{{  $e->id }}_{{$k}}.png" style="max-width:400px; max-height: 250px" /><br>
                                                                        <a class="" href="/svg/{{ $experiment->id }}/{{  $e->id }}_{{$k}}.svg"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> SVG</a> <a class="" href="/svg/{{ $experiment->id }}/{{  $e->id }}_{{$k}}.png"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> PNG</a>
                                                                    </a>
                                                                </td>
                                                            @elseif($e->type == 4)
                                                                <td>
                                                                    <div style="width: 400px"></div>
                                                                    {{ json_decode($student[$e->id]->value,true)['feedback'] }}
                                                                </td>
                                                            @elseif($e->type == 2)
                                                                <td>
                                                                    <div style="width: 400px"></div>
                                                                    @foreach(json_decode($student[$e->id]->value,true) as $field => $value)
                                                                        @if($fields[$field]->type == 3 OR $fields[$field]->type == 4 or $fields[$field]->type == 5)
                                                                            @if(array_key_exists($field, $fields))
                                                                                <label style="width: 150px; white-space:normal">{{ $fields[$field]->name.":"}}</label>{{ \App\Field::getFieldAnswers($field, $value) }}<br>
                                                                            @endif
                                                                        @else
                                                                            <label style="width: 150px; white-space:normal">{{ $fields[$field]->name.": " }}</label>{{ $value }}<br>
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            @else
                                                                <td><div style="width: 400px"></div>{{ $student[$e->id]->value }}</td>
                                                            @endif
                                                        @else
                                                            <td></td>
                                                        @endif


                                                @endforeach
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="right"></div>
@stop