@extends('app')

@section('head')
    <script src="/js/bpmn-js/dist/bpmn-viewer.js"></script>
    <script>
       $(function() {
            var BpmnViewer = window.BpmnJS;
            // var viewer = new BpmnViewer({ container: $('#js-canvas'), height: 600 });


            $('.canvas').each(function() {
                var inhalt = $(this).attr('content');
                var user = $(this).attr('user');

                var viewer = new BpmnViewer({ container: $(this), height: 300  });
                viewer.importXML(inhalt, function (err) {
                    if (err) {
                        console.log('something went wrong:', err);
                    } else {
                        viewer.get('canvas').zoom('fit-viewport');
                    }
                });

            });

            $('.datatable').DataTable({
                'scrollX': true,
                'scrollY': 'calc(100vh - 245px)'
            });
        });
    </script>
    <style>
        .canvas {
            border: 1px solid #ddd;
        }
        div.dataTables_wrapper {
            width: 100%;
            height: 500px;

        }
        .table th, .table td {

        }
        .container {
            top: 60px;
            bottom: 0;
            left: 0;
            right: 0;
            position: fixed;
            width: 100%;
            height: 100%;
        }
    </style>
@stop


@section('content')

    <div class="container">


            <h2>Auswertung: {{ $experiment->title }}</h2>

            <table class="table datatable table-striped table-bordered" width="100%">

                <thead>
                    <tr>
                        <th>XOR-Pfad</th>
                        @foreach($elements as $element)
                            @if(!is_array($element))
                                <th>{{ $element->title }}</th>
                            @endif
                        @endforeach
                        <th>Pfad-Elemente</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($antworten as $k => $student)
                        <tr>

                            <td>Pfad {{ \App\Answer::getPfad($k)+1 }}</td>

                            @foreach($elements as $key => $element)
                                @if(!is_array($element))
                                    @if(array_key_exists($element->id, $student))
                                        @if($element->type == 3)
                                            <td width="500">
                                                <div style="width: 500px"></div>
                                                <div user="{{$k}}" class='canvas canvas{{$k}}' content='{!! str_replace("\n","",$student[$element->id]->value) !!}'> </div>
                                                <a href="/auswertung/timeline/{{  $element->id }}/{{$k}}">Zeitleiste</a>
                                            </td>
                                        @elseif($element->type == 4)
                                            <td width="350">
                                                <div style="width: 350px"></div>
                                                {{ json_decode($student[$element->id]->value,true)['feedback'] }}
                                            </td>
                                        @elseif($element->type == 2)
                                            <td width="400">
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
                                            <td width="500">{{ $student[$element->id]->value }}</td>
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
                                            <tr>
                                                @if(array_key_exists(\App\Answer::getPfad($k), $element))
                                                    @foreach($element[\App\Answer::getPfad($k)] as $e)

                                                        <th>{{ $e->title }}</th>
                                                    @endforeach
                                                @endif
                                            </tr>
                                                <tr>
                                                @if(array_key_exists(\App\Answer::getPfad($k), $element))
                                                @foreach($element[\App\Answer::getPfad($k)] as $e)


                                                        @if(array_key_exists($e->id, $student))
                                                            @if($e->type == 3)
                                                                <td width="500">
                                                                    <div style="width: 500px"></div>
                                                                    <div user="{{$k}}" class='canvas canvas{{$k}}' content='{!! str_replace("\n","",$student[$e->id]->value) !!}'> </div>
                                                                    <a href="/auswertung/timeline/{{  $e->id }}/{{$k}}">Zeitleiste</a>
                                                                </td>
                                                            @elseif($e->type == 4)
                                                                <td width="350">
                                                                    <div style="width: 350px"></div>
                                                                    {{ json_decode($student[$e->id]->value,true)['feedback'] }}
                                                                </td>
                                                            @elseif($e->type == 2)
                                                                <td width="400">
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
                                                                <td width="500">{{ $student[$e->id]->value }}</td>
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
@stop