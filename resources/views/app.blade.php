<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title></title>
    <link  href="/css/bootstrap.min.css" rel="stylesheet" media="all" />
    <script src="/js/jquery.min.js"     type="text/javascript"></script>
    <script src="/js/bootstrap.min.js"  type="text/javascript"></script>
    <script src="/js/jquery-ui.min.js"  type="text/javascript"></script>
    @yield('head')
</head>
<body>

<nav class="navbar navbar-default ">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="padding: 3px 16px;" href="http://www.uni-ulm.de/"><img src="/img/uulm.png"/> </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is( '/') ? 'active' : '' }}">
                    <a href="{{ URL::to( '/') }}">Start</a>
                </li>

                @if(Auth::user())
                    <li class="{{ Request::is( 'experiment*') ? 'active' : '' }}">
                        <a href="{{ URL::to( '/experiment') }}">Experiment</a>
                    </li>
                @endif


                    <!--
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                    -->
            </ul>

            <ul class="nav navbar-nav navbar-right">

                @if(Auth::user())
                    <p class="navbar-text">Eingeloggt als {{ Auth::user()->name }} </p>
                    <li><a href="/auth/logout">Logout</a></li>
                @else
                    <li><a href="/auth/register">Register</a></li>
                    <li><a href="/auth/login">Login</a></li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<div class="container-fluid">
@yield("content")
</div>



</body>
</html>