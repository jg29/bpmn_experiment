@extends('app')

@section('content')

    <div class="container">
        <div class="form">

            <h2>Eigene Experimente</h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titel des Experimentes</th>
                        <th>Key</th>
                        <th colspan="4">Bearbeiten</th>
                    </tr>
                </thead>
                    @if(count($experimentsOwn) != 0)
                        @foreach ($experimentsData as $experiment)
                            @if(in_array($experiment->id, $experimentsOwn))
                                <tr>
                                    <td>{{ $experiment->title }}</td>
                                    <td>
                                        @foreach($hash[$experiment->id] as $key => $wert)
                                            XOR-Key {{ $key+1 }}: {{ $experiment->key }}-{{$wert}} <br>
                                        @endforeach
                                    </td>

                                    <td width="10"><a href="experiment/{{ $experiment->id }}/edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                                    <td width="10"><a href="freigabe/{{ $experiment->id }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></td>
                                    <td width="10"><a href="auswertung/{{ $experiment->id }}"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></a></td>
                                    <td width="10">
                                        {!! Form::open(array('route' => array('experiment.destroy', $experiment->id), 'method' => 'delete')) !!}
                                            <a href="#" onclick="if(confirm('Experiment löschen?')) {$(this).parent().submit()} else {return false;}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                        {!! Form::close()  !!}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr><td colspan="4">Keine eigenen Experimente</td></tr>
                    @endif
            </table>

            <a href="experiment/create" class="btn btn-default" role="button">Neues Experiment</a>
        </div>
    </div>

    <div class="container">
        <div class="form">

            <h2>Geteilte Experimente</h2>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Titel des Experimentes</th>
                    <th>Key</th>
                    <th colspan="4">Bearbeiten</th>
                </tr>
                </thead>
                @if(count($experimentsView)+count($experimentsEdit) != 0)
                    @foreach($experimentsData as $experiment)
                        @if(in_array($experiment->id, $experimentsView) or in_array($experiment->id, $experimentsEdit))
                            <tr>
                                <td>{{ $experiment->title }}</td>
                                <td>
                                    @foreach($hash[$experiment->id] as $key => $wert)
                                        XOR-Key {{ $key+1 }}: {{ $experiment->key }}-{{$wert}} <br>
                                    @endforeach
                                </td>
                                @if(in_array($experiment->id, $experimentsEdit))
                                    <td width="10"><a href="experiment/{{ $experiment->id }}/edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                                @else
                                    <td width="10"></td>
                                @endif
                                @if(in_array($experiment->id, $experimentsView))
                                    <td width="10"><a href="auswertung/{{ $experiment->id }}"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></a></td>
                                @else
                                    <td width="10"></td>
                                @endif
                                <td width="10"></td>
                                <td width="10"></td>

                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr><td colspan="4">Keine geteilten Experimente</td></tr>
                @endif
            </table>
        </div>
    </div>
@stop