@extends('layout', ['template_titulo' => "Mensaje importante"])
@section('contenido')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div>
            <form action="" id="formDet" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="msg"></div>
                        @if(session('mensaje_error'))
                        <div class="alert alert-{{ session('mensaje_error')['tipo'] }}">
                            <h4>Atención</h4>
                            <?php
                            echo session('mensaje_error')["mensaje"];
                            ?>
                        </div>
                        @endif
                        <?php
                            Session::put("mensaje_error", "");
                        ?>     
                    </div>                    
                </div>
               
            </form>
        </div>
    </div>
</div>

@endsection