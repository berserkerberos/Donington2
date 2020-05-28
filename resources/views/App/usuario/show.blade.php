@extends('layout', ['template_titulo' => "Usuario"])

@section('contenido')
<div class="flex-center position-ref full-height">
    <div class="content">            
        <div class="row">            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Usuario {{ $usuario->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/usuario') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <a href="{{ url('/usuario/' . $usuario->id . '/edit') }}" title="Edit Usuario"><button class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</button></a>

                        <form method="POST" action="{{ url('usuario' . '/' . $usuario->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Usuario" onclick="return confirm(&quot;Confirma eliminar?&quot;)"><i class="far fa-trash-alt"></i> Eliminar</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $usuario->id }}</td>
                                    </tr>
                                    <tr><th> Nombre </th><td> {{ $usuario->nombre }} </td></tr><tr><th> Nombre Completo </th><td> {{ $usuario->nombre_completo }} </td></tr><tr><th> Password </th><td> {{ $usuario->password }} </td></tr><tr><th> Avatar </th><td> {{ $usuario->avatar }} </td></tr><tr><th> Usu Verificado </th><td> {{ $usuario->usu_verificado }} </td></tr><tr><th> Tipo </th><td> {{ $usuario->tipo }} </td></tr><tr><th> Direccion </th><td> {{ $usuario->direccion }} </td></tr><tr><th> Localidad </th><td> {{ $usuario->localidad }} </td></tr>
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
