@extends('layout', ['template_titulo' => "Bienvenido"])
@section('contenido')
<script>
$(function(){
    $("#prueba").on("click",function(){
        modalGeneral('Info', 'puede hacer click en si o no', 
            function(){ alert('click en si')}, 
            function(){alert('click en no')}
        );
    });
})
</script>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div>
            <form action="" id="formDet" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="msg"></div>
                        @if(session('mensaje'))
                        <div class="alert alert-{{ session('mensaje')['tipo'] }}">
                            <h4>Atención</h4>
                            <?php
                            echo session('mensaje')["mensaje"];
                            ?>
                        </div>
                        @endif                             
                        <p>Todas la opciones correspondientes a su perfil se encuentran a la izquierda de la pantalla</p>
                        <p>
                        El manual de usuario para la herramienta es el siguiente 
                            <a href="#" class="btn btn-info" >Manual</a>                        
                        </p>
                        <p>Prueba de modal</p>
                        <button type="button" id="prueba" class="btn btn-info btn-lg" >Click aca <i class="fab fa-angellist"></i></button>
                    </div>                    
                </div>
               
            </form>
        </div>
    </div>
</div>
@endsection