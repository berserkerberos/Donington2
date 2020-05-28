<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Transferencias - {{$template_titulo}} </title>

    <!-- Bootstrap core CSS -->    
    <link href="{{asset('/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="{{asset('/css/landing-page.css')}}" rel="stylesheet">

    <style>
        .form-login {
            background-color: #EDEDED;
            border-radius: 15px;
            border-color: #d2d2d2;
            border-width: 5px;
            box-shadow: 0 1px 0 #cfcfcf;
            padding: 40px;
        }

        h4 {
            border: 0 solid #fff;
            border-bottom-width: 1px;
            padding-bottom: 10px;
            text-align: center;
        }

        h1 {
            text-shadow: 5px 5px 3px rgba(0, 0, 0, 0.71);
        }

        .form-control {
            border-radius: 10px;
        }
        .titulo {
            font-size: 4em;
        }
    </style>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="#" style="width:100%" >Transferencias
                <img src="{{asset('/img/logo.png')}}" alt="" style="height: 48px;float: right;" >
            </a>
        </div>
    </nav>

    @yield('contenido')
    <!-- Masthead -->
  
    <?php 
    /*
    ?>

    <!-- Image Showcases -->
    <section class="showcase">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/bg-showcase-3.jpg');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Easy to Use &amp; Customize</h2>
                    <p class="lead mb-0">Landing Page is just HTML and CSS with a splash of SCSS for users who demand some deeper
                        customization options. Out of the box, just add your content and images, and your new landing page will be
                        ready to go!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="call-to-action text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h2 class="mb-4">Ready to get started? Sign up now!</h2>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <form>
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0">
                                <input type="email" class="form-control form-control-lg" placeholder="Enter your email...">
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-block btn-lg btn-primary">Sign up!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php 
      **/
    ?>
    <!-- Footer -->
    <footer class="footer bg-light">        
        
			<div class="container">
				<div class="row">
					<div class="col-md-5 ">
						<a href="http://grupoolmos.com.ar/site/index.html">                             
                            <img src="{{asset('/img/logo.png')}}" alt="" style="height: 160px;float: left;" >
						</a>
						<p></p>
						
					</div>
					<div class="col-md-7">
						<h5>Contactos</h5>
						<hr>
						<dl class="contact-list">
							<dt>Dirección:</dt>
							<dd>Azopardo 1405 Piso 7°.</dd>
							<dd>Ciudad Autónoma de Buenos Aires. Argentina.</dd>
						</dl>

						<dl class="contact-list">
							<dt>Telefono:</dt>
							<dd>5263-5480</dd>
						</dl>
					</div>

				</div>
			</div>
		

    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

</body>

</html>