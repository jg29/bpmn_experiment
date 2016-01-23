@extends('app')

@section('content')

    <div class="container">
        <div class="form">

            <h2>Experimente</h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titel des Experimentes</th>
                        <th>Key</th>
                        <th colspan="2" width="50">Bearbeiten</th>
                    </tr>
                </thead>
                    @forelse ($experiments as $experiment)
                    <tr>
                        <td>{{ $experiment->title }}</td>
                        <td>{{ $experiment->key }}</td>
                        <td><a href="experiment/{{ $experiment->id }}/edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                        <td><a href="experiment/{{ $experiment->id }}/edit"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
                    </tr>
                    @empty
                        <tr><td>Keine eigenen Experimente</td></tr>
                    @endforelse
            </table>

            <a href="experiment/create" class="btn btn-default" role="button">Neues Experiment</a>
        </div>
    </div>
@stop