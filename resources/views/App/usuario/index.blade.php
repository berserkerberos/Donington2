@extends('layout', ['template_titulo' => "Usuario"])

@section('contenido')
<div class="flex-center position-ref full-height">
    <div class="content">            
        <div class="row">            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Usuario</div>
                    <div class="card-body">
                        <a href="{{ url('/usuario/create') }}" class="btn btn-success btn-sm" title="Agregar nuevo Usuario">
                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo
                        </a>

                        <form method="GET" action="{{ url('/usuario') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-info" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Nombre</th><th>Nombre Completo</th><th>Password</th><th>Avatar</th><th>Usu Verificado</th><th>Tipo</th><th>Direccion</th><th>Localidad</th>
                                        <th>
                                            <div class="float-right">
                                                Opciones
                                            </div>
                                        </th>          
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($usuario as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nombre }}</td><td>{{ $item->nombre_completo }}</td><td>{{ $item->password }}</td>
                                        <td><img style="height: 75px;" class="img-fluid" src="{{ asset(Storage::url($item->avatar)) }}" alt="firmaDigital" /></td>
                                        <td>{{ $item->usu_verificado }}</td><td>{{ $item->tipo }}</td><td>{{ $item->direccion }}</td><td>{{ $item->localidad }}</td>
                                        <td>
                                            <div class="float-right" >
                                                <a href="{{ url('/usuario/' . $item->id) }}" title="View Usuario"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Ver</button></a>
                                                <a href="{{ url('/usuario/' . $item->id . '/edit') }}" title="Edit Usuario"><button class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar</button></a>

                                                <form method="POST" action="{{ url('/usuario' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Usuario" onclick="return confirm(&quot;Confirma eliminar?&quot;)"><i class="far fa-trash-alt"></i> Eliminar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $usuario->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
