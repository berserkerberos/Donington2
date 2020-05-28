@extends('layout', ['template_titulo' => "Perfil registrado"])
@section('contenido')
<style>
    .destaca {
        border-bottom: solid 1px
    }
</style>

<div class="flex-center position-ref full-height">
    <div class="content">
        <div>
            <form action="{{route('padron.actualizaUsuario')}}" id="formDet" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        @if(session('mensaje'))
                        <div class="alert alert-{{ session('mensaje')['tipo'] }}">
                            <h4>Atención</h4>
                            <?php
                            echo session('mensaje')["mensaje"];
                            ?>
                        </div>
                        @endif
                        @if (count($errors) > 0)
                        <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                       <!-- <div class="alert alert-danger">
                            <strong>Error de carga!</strong>
                            <p>En el campos "Avatar" debe cargar un archivo de imagen con los siguientes formatos:</p>
                            <p>jpeg, png, jpg, gif, svg</p>
                            <p>No debe superar el 1mb de tamaño</p>


                        </div>-->
                        @endif
                        <div class="row">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group  {{ $errors->has('nombre') ? 'has-error' : ''}}">
                                                    <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
                                                    <input class="form-control" name="nombre" type="text" id="nombre" value="{{ isset($usuario->nombre) ? $usuario->nombre : ''}}" required>
                                                    {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group  {{ $errors->has('nombre_completo') ? 'has-error' : ''}}">
                                                    <label for="nombre_completo" class="control-label">{{ 'Nombre Completo' }}</label>
                                                    <input class="form-control" name="nombre_completo" type="text" id="nombre_completo" value="{{ isset($usuario->nombre_completo) ? $usuario->nombre_completo : ''}}" required>
                                                    {!! $errors->first('nombre_completo', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group  {{ $errors->has('password') ? 'has-error' : ''}}">
                                                    <label for="password" class="control-label">{{ 'Password' }}</label>
                                                    <input class="form-control" name="password" type="password" id="password" required>
                                                    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Confirme su password</label>
                                                    <div class="input-group mb-3">
                                                        <input type="password" id="confirme_su_password" name="confirme_su_password" class="form-control" value="" placeholder="reconfirmar clave" required />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8">
                                                <div class="form-group  {{ $errors->has('direccion') ? 'has-error' : ''}}">
                                                    <label for="direccion" class="control-label">{{ 'Direccion' }}</label>
                                                    <input class="form-control" name="direccion" type="text" id="direccion" value="{{ isset($usuario->direccion) ? $usuario->direccion : ''}}" required>
                                                    {!! $errors->first('direccion', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group  {{ $errors->has('localidad') ? 'has-error' : ''}}">
                                                    <label for="localidad" class="control-label">{{ 'Localidad' }}</label>
                                                    <input class="form-control" name="localidad" type="text" id="localidad" value="{{ isset($usuario->localidad) ? $usuario->localidad : ''}}" required>
                                                    {!! $errors->first('localidad', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group  {{ $errors->has('mail') ? 'has-error' : ''}}">
                                                    <label for="mail" class="control-label">{{ 'Mail' }}</label>
                                                    <input class="form-control" name="mail" type="text" id="mail" value="{{ isset($usuario->mail) ? $usuario->mail : ''}}" required>
                                                    {!! $errors->first('mail', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group  {{ $errors->has('telefono') ? 'has-error' : ''}}">
                                                    <label for="telefono" class="control-label">{{ 'Telefono' }}</label>
                                                    <input class="form-control" name="telefono" type="text" id="telefono" value="{{ isset($usuario->telefono) ? $usuario->telefono : ''}}" required>
                                                    {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Firma digital</label>
                                                    <div class="input-group mb-3">
                                                        <img style="height: 200px;" class="img-fluid" src="{{ asset(Storage::url($usuario->avatar)) }}" alt="firmaDigital" />
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-12">
                                                <div class="form-group  {{ $errors->has('avatar') ? 'has-error' : ''}}">
                                                    <label for="avatar" class="control-label">{{ 'Avatar' }}</label>
                                                    <input class="form-control" name="avatar" type="file" id="avatar" value="{{ isset($usuario->avatar) ? $usuario->avatar : ''}}">
                                                    {!! $errors->first('avatar', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>                                            

                                        </div>
                                    </div>
                                </div>

                            </div>



                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right">
                                    <br>
                                    <button type="submit" class="btn btn-info" id="btnActualizar"> Actualizar datos </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection