<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>@yield('title', 'AQP Eventos - 2018')</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/material-kit.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/material-dashboard.css?v=1.2.0') }}" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />
    
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/ui.jqgrid.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/jquery-confirm.css') }}" rel="stylesheet">
    
    <link href="{{ asset('css/sweetalert2.css') }}" rel="stylesheet">


</head>

<body class="@yield('body-class')">
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">AQP EVENTOS</a>
                @guest
                @else
                  <center><a class="navbar-brand" href="#"> BIENVENIDO : {{ Auth::user()->name }} </a></center>
                  <br>
                  
                  <a href="{{ route('logout') }}" type="btn btn-danger btn-lg"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Cerrar Sesion
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                @endguest
                
            </div>

            <div class="collapse navbar-collapse" id="navigation-example">
                <ul class="nav navbar-nav navbar-right">
                    
                    @guest
                        <li><a href="{{ route('login') }}">INGRESAR</a></li>
                        <li><a href="{{ route('register') }}">REGISTRO</a></li>
                    @else
                        
                    @endguest

                    <li>
                        <a href="https://twitter.com/CreativeTim" target="_blank" class="btn btn-simple btn-white btn-just-icon">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/CreativeTim" target="_blank" class="btn btn-simple btn-white btn-just-icon">
                            <i class="fa fa-facebook-square"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/CreativeTimOfficial" target="_blank" class="btn btn-simple btn-white btn-just-icon">
                            <i class="fa fa-instagram"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper">
        @yield('content')
    </div>
    
    <div style="display:none;">
    <audio id="audio_smallbox" controls>
    <source type="audio/mp3" src="{{ asset('sound/smallbox.mp3') }}">
    </audio>
    <audio id="audio_messagebox" controls>
    <source type="audio/mp3" src="{{ asset('sound/messagebox.mp3') }}">
    </audio>
    </div>

</body>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('archivos_js/preinscripciones/preinscripciones.js') }}" type="text/javascript"></script>
    <script src="{{ asset('archivos_js/principal/contenido.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material.min.js') }}"></script>
    <script src="{{ asset('js/nouislider.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material-kit.js') }}" type="text/javascript"></script>
    
    <script src="{{ asset('js/block_ui.js') }}"></script>
    <script src="{{ asset('js/jquery-confirm.js')}}"></script>
    <script src="{{ asset('js/grid.locale-en.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.jqGrid.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/i18n/grid.locale-es.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-ui.js') }}" type="text/javascript"></script>
    
    <script src="{{ asset('archivos_js/global_function.js') }}"></script>
    <script src=" {{ asset('js/sweetalert2.js') }} " type="text/javascript"></script>

</html>


                       