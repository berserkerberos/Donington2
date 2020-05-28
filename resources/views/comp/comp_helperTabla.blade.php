<div class="table-responsive">
    <table class="table table-bordered table-striped table-my" id="{{$tabla_id}}">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                @foreach ($campos as $key => $value)
                <th>{{$value}}</th>
                @endforeach
                @if(!empty($opciones))
                <th style="width: 187px;">Opciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if(!empty($datos))
            @foreach ($datos as $k => $value)
            <tr>
                <td></td>
                @foreach ($value as $key_data => $cam)
                @foreach ($campos as $key_campo => $value)
                @if($key_data == $key_campo)
                <td>{{$cam}}</td>
                @endif
                @endforeach
                @endforeach
                @if(!empty($opciones))
                <td>
                    @foreach ($opciones as $key => $op)
                    <button type="button" data-key="{{$datos[$k]['id']}}" class="btn btn-sm {{$op['clase']}}">{{$op['nombre']}}</button>
                    @endforeach
                </td>
                @endif
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

<script>
    $('#{{$tabla_id}}').DataTable({
        language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
        },
        "searching": false,
        "ordering": false,
        "paging": true        
    });
</script>