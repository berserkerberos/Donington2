@extends('layout', ['template_titulo' => "Transferencia"])

@section('contenido')
<style>
  .enUnaFila {
    white-space: nowrap;
  }
</style>
<script>
  $(function() {


    $("#pnlCopia").hide();

    $("#copiar_entre").on("click", function() {

      var mod = $("#pnlCopia")
      mod.detach().appendTo("#temp_cuerpo");
      $("#pnlCopia").show();
      modalGeneral(
        'Complete los campos indicados',
        "",
        function() {
          var mod = $("#pnlCopia")
          mod.detach().appendTo("#form1");
          $("#pnlCopia").hide();
          $("#form1").prop("action", "{{ url('/trans/copiar') }}")
          $("#form1").submit();
        },
        function() {
          //alert('click en no')
        },
        false
      );

    })

    $("#descargar_entre").on("click", function() {
      $("#form1").prop("action", "{{ url('/trans/descargar') }}")
      $("#form1").submit();
    })

    $("#btnBuscar").on("click", function() {
      $("#form1").prop("action", "{{ url('/transferencia') }}")
      $("#form1").prop("method", "GET")
      $("#form1").submit();
    })

    $(".btnBorrar").on("click", function() {
      id = $(this).data("id");
      $("#form1").prop("action", "{{ url('/transBorrar') }}" + "/" + id);
      $("#form1").prop("method", "POST")
      $("#form1").submit();
    })

    $("#chall").on("click", function() {
      $('.chops').prop('checked', this.checked);
    })

  })
</script>

<div class="flex-center position-ref full-height">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Transferencia</div>
          <div class="card-body">
            <form method="POST" action="" id="form1" accept-charset="UTF-8">
              <div class="pull-left">
                <div class="row">
                  <div class="col-sm-8">

                    @csrf
                    <div class="row">
                      <div class="col-sm-4">

                        <select name="cbEntregas" id="cbEntregas" class="form-control" style="width:100%">
                          <option value="0">--Seleccionar entrega--</option>
                          <?php
                          foreach ($entregas as $key => $value) {
                            echo '<option ' . ($entrega_select == $value->entrega ? "selected" : "") . ' value="' . $value->entrega . '" >' . $value->entrega . '</option>';
                          }
                          ?>
                        </select>


                      </div>
                      <div class="col-sm-8">
                        <div class="btn btn-success btn-sm" id="descargar_entre"> <i class="fa fa-plus" aria-hidden="true"></i> Descargar</div>
                        <div class="btn btn-success btn-sm" id="copiar_entre"> <i class="fa fa-plus" aria-hidden="true"></i> Copiar</div>
                        <a href="{{ url('/transferencia/create') }}" class="btn btn-success btn-sm" title="Agregar nuevo Transferencia">
                          <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo
                        </a>
                      </div>
                    </div>

                  </div>


                  <div class="col-sm-4">

                    <div class="input-group">
                      <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                      <span class="input-group-append">
                        <button class="btn btn-info" type="button" id="btnBuscar">
                          <i class="fa fa-search"></i>
                        </button>
                      </span>
                    </div>

                  </div>
                </div>

              </div>
              <br />
              <br />
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th> <input type="checkbox" id="chall" name="chall"> <label for="chall">#&nbsp;</label></th>
                      <th>Entrega</th>
                      <th>Fecha</th>
                      <th>Cbu Debito</th>
                      <th>Cbu Credito</th>
                      <th>Alias Cbu Debito</th>
                      <th>Alias Cbu Credito</th>
                      <th>Importe</th>
                      <th>Concepto</th>
                      <th>Motivo</th>
                      <th>Referencia</th>
                      <th>Email</th>
                      <th>Titulares</th>
                      <th>
                        <div class="float-right">
                          Opciones
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($transferencia as $item)
                    <tr>
                      <td class="enUnaFila"> <label for="cbox2">{{ $loop->iteration }}</label>&nbsp; <input type="checkbox" name="chops[{{ $loop->iteration }}]" class="chops"></td>
                      <td>{{ $item->entrega }}</td>
                      <td class="enUnaFila">{{ $item->fecha }}</td>
                      <td>{{ $item->cbu_debito }}</td>
                      <td>{{ $item->cbu_credito }}</td>
                      <td>{{ $item->alias_cbu_debito }}</td>
                      <td>{{ $item->alias_cbu_credito }}</td>
                      <td>{{ $item->importe }}</td>
                      <td class="enUnaFila    ">{{ $item->concepto }}</td>
                      <td>{{ $item->motivo }}</td>
                      <td>{{ $item->referencia }}</td>
                      <td>{{ $item->email }}</td>
                      <td>{{ $item->titulares }}</td>
                      <td class="enUnaFila">
                        <div class="float-right">
                          <a href="{{ url('/transferencia/' . $item->id) }}" title="Ver Transferencia" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                          <a href="{{ url('/transferencia/' . $item->id . '/edit') }}" title="Editar Transferencia" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                          <button type="button" class="btn btn-danger btn-sm btnBorrar" data-id="{{$item->id}}" title="Borrar Transferencia" onclick="return confirm('&quot;Confirma eliminar?&quot;')"><i class="far fa-trash-alt"></i></button>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $transferencia->appends(['search' => Request::get('search')])->render() !!} </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div id="pnlCopia">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group ">
            <label for="txNuevaFecha" class="control-label">{{ 'Nueva Fecha' }}</label>
            <input class="form-control" name="txNuevaFecha" type="date" id="txNuevaFecha" value=""></input>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group ">
            <label for="txNuevaEntrega" class="control-label">{{ 'Nueva entrega' }}</label>
            <input class="form-control" name="txNuevaEntrega" type="text" id="txNuevaEntrega" value=""></input>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection