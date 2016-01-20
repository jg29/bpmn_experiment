@extends('app')

@section('content')


    <div class="form">

        <h1>Experimente</h1>

<table>
        @forelse ($experiments as $experiment)
        <tr>
            <td>{{ $experiment->title }}</td>
            <td><a href="experiment/{{ $experiment->id }}/edit">edit</a></td>
        </tr>
        @empty
            <tr><td>Keine eigenen Experimente</td></tr>
        @endforelse
</table>

        <a href="experiment/create">Neues Experiment</a>
    </div>
@stop