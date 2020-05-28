@extends('sitio/layoutSitio', ['template_titulo' => "Login"])
@section('contenido')

<header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <h1 class="titulo"> Ingrese al sitio</h1>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">

                <form action="{{route('padron.validaUsuario')}}" id="formDet" method="POST">
                    @csrf
                    <div class="">
                        <div class="form-login">
                            @if(session('mensaje'))
                            <div class="alert alert-{{ session('mensaje')['tipo'] }}">
                                <h4>Atención</h4>
                                <?php
                                echo session('mensaje')["mensaje"];
                                ?>
                            </div>
                            @endif

                            <h4 style="color:darkgray"> Ingrese con:</h4>
                            <input type="text" id="txUsuario" name="txUsuario" class="form-control input-sm chat-input" placeholder="Usuario" />
                            </br>
                            <input type="password" id="txPassword" name="txPassword" class="form-control input-sm chat-input" placeholder="Clave" />
                            </br>
                            <div class="wrapper">
                                <span class="group-btn">
                                    <button class="btn btn-primary btn-md">Ingresar > </button>
                                </span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-1"></div>
        </div>


    </div>
    </div>
</header>

@endsection