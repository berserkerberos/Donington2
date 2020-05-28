@extends('layout', ['template_titulo' => "Transferencium"])

@section('contenido')
<div class="flex-center position-ref full-height">
    <div class="content">            
        <div class="row">            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Crear un nuevo: Transferencium</div>
                    <div class="card-body">
                        <a href="{{ url('/transferencia') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <br />
                        <br />

                        <form method="POST" action="{{ url('/transferencia') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('App.transferencia.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
