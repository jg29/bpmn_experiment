@extends('app')

@section('content')
    <div class="container">
        <div class="form">
            <h2>Benutzerverwaltung</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="30%">Name</th>
                    <th width="30%">E-Mail</th>
                    <th width="30%">Rechte</th>
                    <th width="10%">Bearbeiten</th>
                </tr>
                </thead>
                @if(count($users) != 0)
                    @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->isAdmin() ? "Admin " : "" }}{{ $user->isEditor() ? "Bearbeiter " : "" }}</td>
                            @if(Auth::user()->id != $user->id)
                                    <td>
                                        <a href="user/{{ $user->id }}/edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                        {!! Form::open(array('route' => array('user.destroy', $user->id), 'method' => 'delete', 'style'=>'display:inline-block;')) !!}
                                        <a href="#" onclick="if(confirm('User löschen?')) {$(this).parent().submit()} else {return false;}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                        {!! Form::close()  !!}
                                    </td>
                                @else
                                    <td><a href="user/{{ $user->id }}/edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                                @endif
                            </tr>
                    @endforeach
                @else
                    <tr><td colspan="4">Keine eigenen Experimente</td></tr>
                @endif
            </table>
            {!! Form::open(array('url' => 'user', 'method' => 'post','class'=>'form-horizontal')) !!}
            <table class="table table-striped">
                <tr>
                    <td width="30%">{!! Form::text('name', null,array('class'=>'form-control')) !!}</td>
                    <td width="30%">{!! Form::text('email', null,array('class'=>'form-control')) !!}</td>
                    <td width="30%">
                        <input type="checkbox" name="recht[]" value="1"> Admin<br>
                        <input type="checkbox" name="recht[]"  value="2"> Bearbeiter
                    </td>
                    <td width="10%">{!! Form::submit('hinzufügen', array('class'=>'btn btn-default')) !!}</td>
                </tr>
            </table>
            {!! Form::close() !!}
        </div>
    </div>
@stop