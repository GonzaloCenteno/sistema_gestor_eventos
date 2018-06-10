@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">MANTENIMIENTO DE USUARIOS</h4>
                </div>
                <div class="card-content">
                <div class="col-xs-6">
                        <div class="input-group">
                            <div class="icon-addon addon-md">
                                <input id="vw_user_txt_buscar" type="text" class="form-control" placeholder="Ingresar Nombre de Usuario">
                            </div>
                            <span class="input-group-btn">
                                <button onclick="buscar_user();" type="button" class="btn btn-default btn-round"><i class="material-icons">search</i> Buscar</button>
                            </span>
                        </div>
                </div>

                <div class="col-xs-6">  

                    @if( $permisos[0]->btn_new ==1 )
                        <button onclick="open_dialog_new_edit_Usuario();" id="btn_vw_usuarios_Nuevo" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Nuevo
                        </button>
                    @else
                        <button onclick="sin_permiso();" id="btn_vw_usuarios_Nuevo" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Nuevo
                        </button>
                    @endif
                    @if( $permisos[0]->btn_edit ==1 )
                        <button onclick="dlg_Editar_Usuario();" id="btn_vw_usuarios_Editar" type="button" class="btn btn-warning btn-round">
                            <span class="btn-label"><i class="material-icons">create</i></span> Modificar
                        </button>
                    @else
                        <button onclick="sin_permiso();" id="btn_vw_usuarios_Editar" type="button" class="btn btn-warning btn-round">
                            <span class="btn-label"><i class="material-icons">create</i></span> Modificar
                        </button>
                    @endif
                    @if( $permisos[0]->btn_del ==1 )
                        <button onclick="dlg_eliminar_usuario();" data-token="{{ csrf_token() }}" id="btn_vw_usuarios_Eliminar" type="button" class="btn btn-danger btn-round">
                            <span class="btn-label"><i class="material-icons">delete</i></span> Eliminar
                        </button>
                    @else
                        <button onclick="sin_permiso();" data-token="{{ csrf_token() }}" id="btn_vw_usuarios_Eliminar" type="button" class="btn btn-danger btn-round">
                        <span class="btn-label"><i class="material-icons">delete</i></span> Eliminar
                        </button>
                    @endif
                </div> 
                    
                </div>
                <article class="col-xs-12">
                        <table id="table_Usuarios"></table>
                        <div id="pager_table_Usuarios" style="color:black;"></div>
                        <br>
                </article>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('archivos_js/configuracion/usuarios.js') }}"></script>

<!-- MODAL USUARIOS -->
<div id="dialog_Editar_Usuario" style="display: none">
<div class="col-xs-4" style="padding: 0px; margin-top: 0px;">
    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" data-background-color="purple">
                                <h4 class="title">EDITAR USUARIO</h4>
                            </div>
                            <div class="card-content">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person add</i>
                                        </span>
                                        <input type="text" id="vw_usuario_name" class="form-control" placeholder="With Material Icons">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">email</i>
                                        </span>
                                        <input type="text" id="vw_usuario_email" class="form-control" placeholder="With Material Icons">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">update</i>
                                        </span>
                                        <input type="text" id="vw_usuario_fecha_creacion" class="form-control" placeholder="With Material Icons">
                                    </div>
                                </div>
                                <div class="col-xs-12" style=" margin-bottom: 10px; padding: 0px;">
                                <ul class="text-left" style="margin-top: 5px !important; margin-bottom: 0px !important; padding: 0px;">                                        
                                        <button type="button" class="btn btn-warning btn-sm btn-round" onclick="fn_new_mod()">
                                            <span class="cr-btn-label"><i class="material-icons">create</i></span> Modificar
                                        </button>
                                </ul>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-3" style="padding: 0px; margin-top: 0px;">
        <article class="col-xs-12" style=" padding-left: 0px !important">
            <table id="table_modulos"></table>
            <div id="pager_table_modulos"></div>
        </article>
        <div class="col-xs-12" style=" margin-bottom: 10px; padding: 0px;">
            <ul class="text-left" style="margin-top: 5px !important; margin-bottom: 0px !important; padding: 0px;">                                        
                    <button type="button" class="btn btn-success btn-sm btn-round" onclick="fn_new_mod()">
                        <span class="cr-btn-label"><i class="material-icons">add</i></span> Nuevo
                    </button>
                    <button type="button" class="btn btn-warning btn-sm btn-round" onclick="fn_edit_mod()">
                        <span class="cr-btn-label"><i class="material-icons">create</i></span> Editar
                    </button>
                    <button id="btn_delmod" data-token="{{ csrf_token() }}" type="button" class="btn btn-danger btn-sm btn-round" onclick="fn_borrar_Modulo()">
                        <span class="cr-btn-label"><i class="material-icons">delete</i></span> Borrar
                    </button>
                    
            </ul>
        </div>
    </div>
    <div class="col-xs-5" style="padding: 0px; margin-top: 0px;">
        <article class="col-xs-12" style=" padding-left: 0px !important">
            <table id="table_sub_modulos"></table>
            <div id="pager_table_sub_modulos"></div>
        </article>
        <div class="col-xs-12" style=" margin-bottom: 10px; padding: 0px;">
            <ul class="text-right" style="margin-top: 5px !important; margin-bottom: 0px !important; padding: 0px;"><center>                                        
                    <button type="button" class="btn btn-success btn-sm btn-round" onclick="fn_new_submod()">
                        <span class="cr-btn-label"><i class="material-icons">add</i></span> Nuevo
                    </button>
                    <button type="button" class="btn btn-warning btn-sm btn-round" onclick="fn_edit_submod()">
                        <span class="cr-btn-label"><i class="material-icons">create</i></span> Editar
                    </button>
                    <button id="btn_delsubmod" data-token="{{ csrf_token() }}" type="button" class="btn btn-danger btn-sm btn-round" onclick="fn_borrar_subModulo()">
                        <span class="cr-btn-label"><i class="material-icons">delete</i></span> Borrar
                    </button></center>
            </ul>
        </div>
    </div>
</div>

<!-- MODAL MODULOS -->

<div id="dlg_modulos" style="display: none;">
    <input type="hidden" id="hidden_id_mod" value="0"/>
    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" data-background-color="purple">
                                <h4 class="title">INFORMACION MODULO</h4>
                            </div>
                            <div class="card-content">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_des_mod" class="form-control" placeholder="Nombre del Módulo (Será Visible desde el Menú)">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_title_mod" class="form-control" placeholder="Título Módulo(Se verá cuando pase el mouse sobre la Descrip.)">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_idsis_mod" class="form-control" placeholder="ID SISTEMA">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div> 

<!-- MODAL SUBMODULOS -->


<div id="dlg_submodulos" style="display: none;">
    <input type="hidden" id="hidden_id_submod" value="0"/>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION SUBMODULO</h4>
                        </div>
                        <div class="card-content">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_des_submod" class="form-control" placeholder="Nombre del Sub Módulo (Será Visible desde el Menú)">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_title_submod" class="form-control" placeholder="Título Sub Módulo(Se verá cuando pase el mouse sobre la Descrip.)">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_idsis_submod" class="form-control" placeholder="ID SISTEMA DEL SUBMODULO">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_ruta_submod" class="form-control" placeholder="ruta sub modulo">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_orden_submod" class="form-control" placeholder="Orden del menú">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 


<!-- MANTENIMIENTO DE USUARIOS -->

<div id="dialog_new_edit_Usuario" style="display: none">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION USUARIO</h4>
                        </div>
                        <div class="card-content">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_nombre_completo" class="form-control" placeholder="Nombre Completo">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="email" id="dlg_email" class="form-control" placeholder="Correo Electronico">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
