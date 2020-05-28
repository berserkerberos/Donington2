@extends('layout', ['template_titulo' => "Transferencium"])

@section('contenido')
<div class="flex-center position-ref full-height">
    <div class="content">            
        <div class="row">            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Transferencium {{ $transferencium->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/transferencia') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <a href="{{ url('/transferencia/' . $transferencium->id . '/edit') }}" title="Edit Transferencium"><button class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</button></a>

                        <form method="POST" action="{{ url('transferencia' . '/' . $transferencium->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Transferencium" onclick="return confirm(&quot;Confirma eliminar?&quot;)"><i class="far fa-trash-alt"></i> Eliminar</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $transferencium->id }}</td>
                                    </tr>
                                    <tr><th> Entrega </th><td> {{ $transferencium->entrega }} </td></tr><tr><th> Fecha </th><td> {{ $transferencium->fecha }} </td></tr><tr><th> Cbu Debito </th><td> {{ $transferencium->cbu_debito }} </td></tr><tr><th> Cbu Credito </th><td> {{ $transferencium->cbu_credito }} </td></tr><tr><th> Alias Cbu Debito </th><td> {{ $transferencium->alias_cbu_debito }} </td></tr><tr><th> Alias Cbu Credito </th><td> {{ $transferencium->alias_cbu_credito }} </td></tr><tr><th> Importe </th><td> {{ $transferencium->importe }} </td></tr><tr><th> Concepto </th><td> {{ $transferencium->concepto }} </td></tr><tr><th> Motivo </th><td> {{ $transferencium->motivo }} </td></tr><tr><th> Referencia </th><td> {{ $transferencium->referencia }} </td></tr><tr><th> Email </th><td> {{ $transferencium->email }} </td></tr><tr><th> Titulares </th><td> {{ $transferencium->titulares }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
