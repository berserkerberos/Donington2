<div class="row">

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('entrega') ? 'has-error' : ''}}">
            <label for="entrega" class="control-label">{{ 'Entrega' }}</label>
            <input class="form-control" name="entrega" type="number" id="entrega" value="{{ isset($transferencium->entrega) ? $transferencium->entrega : ''}}" required>
            {!! $errors->first('entrega', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('fecha') ? 'has-error' : ''}}">
            <label for="fecha" class="control-label">{{ 'Fecha' }}</label>
            <input class="form-control" name="fecha" type="date" id="fecha" value="{{ isset($transferencium->fecha) ? $transferencium->fecha : ''}}" required>
            {!! $errors->first('fecha', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('cbu_debito') ? 'has-error' : ''}}">
            <label for="cbu_debito" class="control-label">{{ 'Cbu Debito' }}</label>
            <input class="form-control" name="cbu_debito" type="text" id="cbu_debito" value="{{ isset($transferencium->cbu_debito) ? $transferencium->cbu_debito : ''}}">
            {!! $errors->first('cbu_debito', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('cbu_credito') ? 'has-error' : ''}}">
            <label for="cbu_credito" class="control-label">{{ 'Cbu Credito' }}</label>
            <input class="form-control" name="cbu_credito" type="text" id="cbu_credito" value="{{ isset($transferencium->cbu_credito) ? $transferencium->cbu_credito : ''}}">
            {!! $errors->first('cbu_credito', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('alias_cbu_debito') ? 'has-error' : ''}}">
            <label for="alias_cbu_debito" class="control-label">{{ 'Alias Cbu Debito' }}</label>
            <input class="form-control" name="alias_cbu_debito" type="text" id="alias_cbu_debito" value="{{ isset($transferencium->alias_cbu_debito) ? $transferencium->alias_cbu_debito : ''}}">
            {!! $errors->first('alias_cbu_debito', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('alias_cbu_credito') ? 'has-error' : ''}}">
            <label for="alias_cbu_credito" class="control-label">{{ 'Alias Cbu Credito' }}</label>
            <input class="form-control" name="alias_cbu_credito" type="text" id="alias_cbu_credito" value="{{ isset($transferencium->alias_cbu_credito) ? $transferencium->alias_cbu_credito : ''}}">
            {!! $errors->first('alias_cbu_credito', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('importe') ? 'has-error' : ''}}">
            <label for="importe" class="control-label">{{ 'Importe' }}</label>
            <input class="form-control" name="importe" type="number" id="importe" value="{{ isset($transferencium->importe) ? $transferencium->importe : ''}}">
            {!! $errors->first('importe', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('concepto') ? 'has-error' : ''}}">
            <label for="concepto" class="control-label">{{ 'Concepto' }}</label>
            <input class="form-control" name="concepto" type="text" id="concepto" value="{{ isset($transferencium->concepto) ? $transferencium->concepto : ''}}">
            {!! $errors->first('concepto', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('motivo') ? 'has-error' : ''}}">
            <label for="motivo" class="control-label">{{ 'Motivo' }}</label>
            <input class="form-control" name="motivo" type="text" id="motivo" value="{{ isset($transferencium->motivo) ? $transferencium->motivo : ''}}"></input>
            {!! $errors->first('motivo', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('referencia') ? 'has-error' : ''}}">
            <label for="referencia" class="control-label">{{ 'Referencia' }}</label>
            <input class="form-control" name="referencia" type="text" id="referencia" value="{{ isset($transferencium->referencia) ? $transferencium->referencia : ''}}"></input>
            {!! $errors->first('referencia', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('email') ? 'has-error' : ''}}">
            <label for="email" class="control-label">{{ 'Email' }}</label>
            <input class="form-control" name="email" type="text" id="email" value="{{ isset($transferencium->email) ? $transferencium->email : ''}}">
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group  {{ $errors->has('titulares') ? 'has-error' : ''}}">
            <label for="titulares" class="control-label">{{ 'Titulares' }}</label>
            <input class="form-control" name="titulares" type="text" id="titulares" value="{{ isset($transferencium->titulares) ? $transferencium->titulares : ''}}">
            {!! $errors->first('titulares', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <button class="btn btn-primary" type="submit" value=""><?php echo ($formMode === 'edit' ? 'Modificar <i class="far fa-save"></i>' : 'Crear <i class="far fa-save"></i>'); ?></button>
        </div>
    </div>

</div>