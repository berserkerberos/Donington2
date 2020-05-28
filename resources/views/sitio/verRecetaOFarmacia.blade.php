@extends('sitio/layoutSitio', ['template_titulo' => "Login"])

@section('contenido')

<div>


    <!-- Image Showcases -->




    <header class="masthead text-white text-center">
        <div class="overlay"></div>
        <div class="container" style="    margin-top: -140px;">


            <div class="row">
                <div class="col-md-12">
                    <br>
                    <h2 class="titulo">Bienvenido</h2>
                    <p class="titulo" style="font-size: 1.5em">
                        Antes de comenzar necesitamos que te identifiques para poder adaptar el sitio. Gracias
                    </p>


                    @if(session('mensaje'))
                    <div class="alert alert-{{ session('mensaje')['tipo'] }}">                            
                        <?php
                        echo session('mensaje')["mensaje"];
                        ?>
                    </div>
                    @endif
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <section class="call-to-farmacia text-white text-center">
                                    <div class="overlay"></div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xl-12 mx-auto">
                                                <h2 class="mb-4">Soy una farmacia, necesito recepcionar una receta</h2>
                                            </div>
                                            <div class="col-xl-4"></div>
                                            <div class="col-xl-4 mx-auto">
                                                <a href="/ingreso" class="btn btn-block btn-lg btn-primary">Ingresar al sitio</a>
                                            </div>
                                            <div class="col-xl-4"></div>

                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-6">
                                <!-- Call to Action -->
                                <section class="call-to-paciente text-white text-center">
                                    <div class="overlay"></div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xl-9 mx-auto">
                                                <h2 class="mb-4">Soy un paciente quiero ver mí receta</h2>
                                            </div>
                                            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                                                <form action="{{route('padron.validarQRconDNI')}}" method="POST" > 
                                                @csrf
                                                    <input type="hidden" name="txqr" value={{$qr}}>
                                                    <div class="form-row">
                                                        <div class="col-12 ">

                                                            <br>
                                                            <div class="input-group ">
                                                                <input type="number" id="txdni" name="txdni" class="form-control form-control-lg" value="" placeholder="DNI" />
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-lg btn-primary" id="btnBuscar"><i class="fa fa-search"></i> Ver receta</button>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <br>
                                                        <div class="col-xl-4 ">

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>




                </div>
            </div>


        </div>
</div>
</header>




<!-- Call to Action -->






</div>

@endsection