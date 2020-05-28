@extends('layout', ['template_titulo' => "Receta generada"])
@section('wizard')
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link " href="{{route('padron.consultarDni')}}">
            <label class="badge badge-pill badge-primary" for="">Paso 1</label>
            (Inique paciente) <i class="fas fa-arrow-right"></i>
            <br>
            <?php
            if (session("afiliado")) {
                $af  = session("afiliado")["data"];
                echo "" . $af->pac_apellido . " " . $af->pac_nombre;
            }
            ?>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link disabled" href="#"><label class="badge badge-pill badge-secondary" for="">Paso 2</label>
            (Agregar item) <i class="fas fa-arrow-right"></i>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link disabled" href="#">
            <label class="badge badge-pill badge-secondary" for="">Paso 3</label>
            (Confirmar Receta) <i class="fas fa-arrow-right"></i>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link active" href="#">
            <label class="badge badge-pill badge-primary" for="">Paso 4</label>
            (Ver Receta)
        </a>
    </li>

</ul>

<hr style="margin-top: 0rem;">

@endsection
@section('contenido')

<script>
    $(function() {

        $("#btnEnviarMail").on("click", function(e) {
            e.preventDefault();

            var form = $("#formDet");
            form.attr("method", "POST");
            form.attr("action", "{{route('padron.sendMailRecetas')}}")
            form.submit();
        });

    });
</script>

<div class="flex-center position-ref full-height">
    <div class="content">
        <div>
            <form action="" id="formDet" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        @if(isset($mensaje))                            
                            <div class="alert alert-{{ $mensaje['tipo'] }}">
                                <h4>Atención</h4>
                                {{$mensaje["mensaje"]}}
                            </div>
                        @else
                            @if(isset( $mensaje_resul))
                                <div class="alert alert-success">
                                    <!--<p>Para poder visualizar el historial de recetas del paciente ' . $afiliado["data"]->pac_dni . ' : <a href="/controllers/pruebas/printCronicos.php" target="_blanck" class="btn btn-info btn-sm" >Click aquí</a></p>-->
                                    <p>
                                        Se han generado las siguientes recetas:
                                        <?php

                                        $recnum = [];
                                        foreach ($mensaje_resul as $key => $value) {
                                            $recnum[] = $value->rec_id;
                                        }
                                        echo implode(",", $recnum);
                                        ?>
                                    </p>
                                </div>

                                <ul class="list-group">
                                    @foreach ($mensaje_resul as $key => $value)
                                    <li class="list-group-item ">Para poder descargar la receta N° {{$value->rec_id }} para el mes de {{\App\Helpers\miPrint::fechaAEspanol($value->rec_vigencia,true)}}, haga :
                                        <a href="/verReceta/{{$value->rec_id }}" target="_blanck" class="btn btn-info btn-sm">Click aquí</a></li>
                                    @endforeach
                                </ul>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Puede enviar las recetas generadas, al afiliado por el siguiente email:</label>
                                        <input type="mail" placeholder="mail@mail.com" name="txmail" class="form-control-sm col-2">
                                        <div class="btn btn-info btn-sm" id="btnEnviarMail"><i class="far fa-paper-plane"></i> Enviar mail</div>
                                    </div>
                                </div>

                                <?php
                                \Session::put("mensaje_resul", "");
                                ?>

                            @endif
                        @endif

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection