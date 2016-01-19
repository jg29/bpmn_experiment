@extends('app')

@section('content')
    <a href="/login">Login</a>


<div class="form">
    <form>
        <h1>Experiment</h1>
        Schlüssel: <input type="text" name="key"><br>
        <input type="submit" value="Start">
    </form>
</div>
@stop