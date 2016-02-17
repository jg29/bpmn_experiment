@extends('app')

@section('head')
    <script>

        $(function() {
            $('option').mousedown(function(e) {
                e.preventDefault();
                $(this).prop('selected', $(this).prop('selected') ? false : true);
                return false;
            });

        })

    </script>

@stop


@section('content')
    <div class="container">
        <div class="form">
            {!! Form::open(array('url' => '/freigabe/'.$experiment->id.'/save', 'method' => 'post', 'class'=>'orderxor')) !!}
            <div class="form-group">
                {!! Form::label('text', 'Bearbeiten:', array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <select multiple name="recht[edit][]" class="form-control">
                    @foreach($users as $user)
                        @if($user->id != Auth::user()->id)
                            @if(is_array($recht) and array_key_exists('edit',$recht) and in_array($user->id,$recht['edit']))
                                <option selected="selected" value="{{ $user->id }}">{{ $user->name }}</option>
                            @else
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endif
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('text', 'Einsehen:', array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <select multiple name="recht[view][]" class="form-control">
                    @foreach($users as $user)
                        @if($user->id != Auth::user()->id)
                            @if(is_array($recht) and array_key_exists('view',$recht) and in_array($user->id,$recht['view']))
                                <option selected="selected" value="{{ $user->id }}">{{ $user->name }}</option>
                            @else
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endif
                    @endforeach
                    </select>
                </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-5">
                    {!! Form::submit('Speichern', array('class'=>'btn btn-default')) !!}
                </div>
            </div>
        </div>
    </div>
@stop