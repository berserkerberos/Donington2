
<div class="row">
    
<div class="col-md-3">
    <div class="form-group  {{ $errors->has('nombre') ? 'has-error' : ''}}">
        <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
        <input class="form-control" name="nombre" type="text" id="nombre" value="{{ isset($usuario->nombre) ? $usuario->nombre : ''}}" required>
        {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('nombre_completo') ? 'has-error' : ''}}">
        <label for="nombre_completo" class="control-label">{{ 'Nombre Completo' }}</label>
        <input class="form-control" name="nombre_completo" type="text" id="nombre_completo" value="{{ isset($usuario->nombre_completo) ? $usuario->nombre_completo : ''}}" required>
        {!! $errors->first('nombre_completo', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('password') ? 'has-error' : ''}}">
        <label for="password" class="control-label">{{ 'Password' }}</label>
        <input class="form-control" name="password" type="password" id="password" required>
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('avatar') ? 'has-error' : ''}}">
        <label for="avatar" class="control-label">{{ 'Avatar' }}</label>
        <input class="form-control" name="avatar" type="file" id="avatar" value="{{ isset($usuario->avatar) ? $usuario->avatar : ''}}" >
        {!! $errors->first('avatar', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('usu_verificado') ? 'has-error' : ''}}">
        <label for="usu_verificado" class="control-label">{{ 'Usu Verificado' }}</label>
        <input class="form-control" name="usu_verificado" type="datetime-local" id="usu_verificado" value="{{ isset($usuario->usu_verificado) ? $usuario->usu_verificado : ''}}" >
        {!! $errors->first('usu_verificado', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('tipo') ? 'has-error' : ''}}">
        <label for="tipo" class="control-label">{{ 'Tipo' }}</label>
        <input class="form-control" name="tipo" type="number" id="tipo" value="{{ isset($usuario->tipo) ? $usuario->tipo : ''}}" required>
        {!! $errors->first('tipo', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('direccion') ? 'has-error' : ''}}">
        <label for="direccion" class="control-label">{{ 'Direccion' }}</label>
        <input class="form-control" name="direccion" type="text" id="direccion" value="{{ isset($usuario->direccion) ? $usuario->direccion : ''}}" required>
        {!! $errors->first('direccion', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('localidad') ? 'has-error' : ''}}">
        <label for="localidad" class="control-label">{{ 'Localidad' }}</label>
        <input class="form-control" name="localidad" type="text" id="localidad" value="{{ isset($usuario->localidad) ? $usuario->localidad : ''}}" required>
        {!! $errors->first('localidad', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('mail') ? 'has-error' : ''}}">
        <label for="mail" class="control-label">{{ 'Mail' }}</label>
        <input class="form-control" name="mail" type="text" id="mail" value="{{ isset($usuario->mail) ? $usuario->mail : ''}}" required>
        {!! $errors->first('mail', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('telefono') ? 'has-error' : ''}}">
        <label for="telefono" class="control-label">{{ 'Telefono' }}</label>
        <input class="form-control" name="telefono" type="text" id="telefono" value="{{ isset($usuario->telefono) ? $usuario->telefono : ''}}" required>
        {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group  {{ $errors->has('observacion') ? 'has-error' : ''}}">
        <label for="observacion" class="control-label">{{ 'Observacion' }}</label>
        <textarea class="form-control" rows="5" name="observacion" type="textarea" id="observacion" required>{{ isset($usuario->observacion) ? $usuario->observacion : ''}}</textarea>
        {!! $errors->first('observacion', '<p class="help-block">:message</p>') !!}
    </div>
</div>

    <div class="col-md-12">
        <div class="form-group">
            <button class="btn btn-primary" type="submit" value=""><?php echo  ($formMode === 'edit' ? 'Modificar <i class="far fa-save"></i>' : 'Crear <i class="far fa-save"></i>'); ?></button>            
        </div>
    </div>
</div>
