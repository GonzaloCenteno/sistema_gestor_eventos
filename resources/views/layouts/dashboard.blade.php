<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="{{ asset('img/flags/PE.png') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title', 'Sistema Gestor de Eventos')</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <!--  Material Dashboard CSS    -->
    <link href="{{ asset('css/material-dashboard.css?v=1.2.0') }}" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/sweetalert2.css') }}" rel="stylesheet">

    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/ui.jqgrid.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/jquery-confirm.css') }}" rel="stylesheet">

    <!-- FULL CALENDAR -->
    <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.print.css" rel="stylesheet" type="text/css" media="print" >
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

    <style>
        #calendario {
        max-width: 900px;
        margin: 0 auto;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="{{ asset('img/sidebar-1.jpg') }}">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    GESTION DE EVENTOS
                </a>
            </div>

            <!-- <div class="sidebar-wrapper">
                <ul class="nav">

                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 20px; padding-bottom: 20px;"><i class="material-icons">dashboard</i><p> CONFIGURACION </p><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li style="width: 240px;"><a href="#" style="padding-top: 10px; padding-bottom: 10px;"><i class="material-icons">add box</i> <p>USUARIOS</p></a></li>
                    </ul>
                </li>

                </ul>
            </div> -->

             <div class="sidebar-wrapper">
                <ul class="nav">
                    @php $vari=0; @endphp
                    @foreach($menu as $per)
                        @if (@$vari!=$per->id_mod)
                            @if($vari>0)
                                </ul>
                               </li>
                            @endif
                            @php $vari=$per->id_mod; @endphp
                             <li class="dropdown" id="{{$per->id_sis_menu}}">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 20px; padding-bottom: 20px;"><i class="material-icons">dashboard</i><p><b> {{$per->descripcion}} </b></p><b class="caret"></b></a>
                                <ul class="dropdown-menu" id="{{$per->id_sis_menu}}">
                        @endif
                        <li id="{{$per->id_sistema}}" style="width: 240px;"><a href="{{$per->ruta_sis}}" style="padding-top: 10px; padding-bottom: 10px;"><i class="material-icons">add box</i> <p>{{$per->des_sub_mod}}</p></a>
                        </li>
                    @endforeach
                    
                </ul>
            </div>
           
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <center><a class="navbar-brand" href="#"> BIENVENIDO : {{ Auth::user()->name }} </a></center>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    <p class="hidden-lg hidden-md">BIENVENIDO : {{ Auth::user()->name }}</p>
                                </a>
                            </li>
                            @if (Auth::guest())
                            <div class="pull-right" style="margin-top: 8px">
                                <a href="{{ route('login') }}" class="btn btn-default ">Iniciar Session</a>                
                            </div>  
                            @else
                            <li>
                                    <a href="{{ route('logout') }}" type="button" class="btn btn-danger btn-round" 
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Cerrar Sesion
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                            </li>
                            @endif
                        </ul>
                        <form class="navbar-form navbar-right" role="search">
                            
                        </form>
                    </div>
                </div>
            </nav>

            <div class="content">
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


        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="{{ asset('js/app.config.js') }}"></script>

<script src="{{ asset('js/block_ui.js') }}"></script>
<script src="{{ asset('js/jquery-confirm.js')}}"></script>

<script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('js/SmartNotification.min.js')}}"></script>

<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="{{ asset('js/chartist.min.js') }}" type="text/javascript"></script>
<!--  Dynamic Elements plugin -->
<script src="{{ asset('js/arrive.min.js') }}" type="text/javascript"></script>
<!--  PerfectScrollbar Library -->
<script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('js/bootstrap-notify.js') }}" type="text/javascript"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{ asset('js/material-dashboard.js?v=1.2.0') }}" type="text/javascript"></script>

<script src=" {{ asset('js/sweetalert2.js') }} " type="text/javascript"></script>

<script src=" {{ asset('js/moment.min.js') }}" type="text/javascript"></script>
<script src=" {{ asset('js/fullcalendar.min.js') }} " type="text/javascript"></script>
<script src=" {{ asset('js/es.js') }} " type="text/javascript"></script>

<script src="{{ asset('js/grid.locale-en.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.jqGrid.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/i18n/grid.locale-es.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery-ui.js') }}" type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ asset('js/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('archivos_js/global_function.js') }}"></script>

</html>