<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../images/favicon.ico">

<title>Donington  - Transferencias</title>

<!-- Bootstrap core CSS -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script>window.jQuery || document.write('<script src="../js/jquery-3.3.1.min.js"><\/script>')</script>

<script src="../js/jquery.easing.js"></script>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/login.css?v2">
<script type="text/javascript" src="../js/login.js"></script>

</head>

<body>


	<div id="top" ></div>
	<nav class="navbar navbar-expand-lg navbar-light fixed-top cabecera " id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">
		<!--<a href="donington.com">-->
						<img class="logo" src="../images/grupo_olmos-logo2.png" alt="" />
			</a>					
		</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#top">Ingreso al sistema</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contactos">Contactos</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

	<div class="">

		<div class="cuerpo">

			<div class="container" id="login" >

				<div class="row">
					<div class="col-md-8">
						<h1 class="titulo_banner">
						Transferencias Donington </br>
						</h1>					
					</div>

					<div class="col-md-4">

						<div class="card card-container">
							<!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
							<p class="texto_login">Ingrese con :</p>
							<form class="form-signin" action="login.php" method="POST"
								id="form">
				
                          <?php
                        if ($mensaje["tipomsg"] != "") {
                            Helper::printMensaje($mensaje["msg"], $mensaje["tipomsg"]);
                        }
                        ?>

						<input type="hidden" id="accion" name="accion" value="" />

								<div id="msg" class="alert alert-danger alert-dismissible"
									role="alert">
									<strong>Error al ingresar.</strong>
									<p class="msgcon"></p>
									<button type="button" class="close" data-dismiss="alert"
										aria-label="Close">
										<span aria-hidden="true" style="float: right;">×</span>
									</button>
								</div>

								<input type="email" id="inputCUIT" name="inputCUIT"
									class="form-control" placeholder="Usuario" required
									style="margin-top: 10px;"> <input type="password"
									id="inputPassword" name="inputPassword" class="form-control"
									placeholder="Password" style="margin-top: 10px;">								
								<br />
								<br />
								<a href="#" class="btn btn-lg btn-primary btn-block btn-signin" 
								id="btnIngCon">Ingrese con contraseña</a>
															
							</form>
							<!-- /form -->

						</div>
						<!-- /card-container -->


					</div>


				</div>

			</div>


		</div>

		
					
	




		<div id="contactos" ></div>	
		<footer class="section footer-classic context-dark bg-image"
			style="background: #cacede;"  >
			<div class="container">
				<div class="row row-30">
					<div class="col-md-7 ">
						
    					<a href="">
    						<img class="logo" src="../images/grupo_olmos-logo2.png" alt="" />
    					</a>
    							
						
						<!-- Rights-->
						<p class="rights">© Copyright 2020. Todos los derechos reservados.</p>

					</div>
					<div class="col-md-5">
						<h5>Contactos</h5>
						<dl class="contact-list">
							
							<dd>Ciudad Autónoma de Buenos Aires. Argentina.</dd>
						</dl>
						<dl class="contact-list">
							<dt>Correo electrónico:</dt>
							<dd>
								<a href="mailto:#">@gmail.com</a>
							</dd>
						</dl>
						<dl class="contact-list">
							<dt>Telefonos:</dt>
							<dd>
								<a href="tel:#"></a> <span>or</span> <a
									href="tel:#"></a>
							</dd>
						</dl>
					</div>

				</div>
			</div>
		</footer>


	</div>



	<script>

	$(function(){

        $("#msg").hide();

		$("#form").on("keypress",function(e){
			if (e.which == 13) {
				$("#btnIngCon").click();
			    return false;    //<---- Add this line
			}
		});
		
		$("#btnIngCon").on("click", function(e){			
            var tmpPass = $("#inputPassword").val();
            var tmpMail = $("#inputCUIT").val();
			console.log(tmpPass);
			console.log(tmpMail);
            if(tmpPass != "" || tmpMail != ""){
                //window.location.href = "Default.php"  
                // sigue y envia el form por post
                $("#accion").val("CON_CONTRASEÑA");
                $("#form").submit();
            }else{
                var msg = ("Por favor complete el CUIT y la contraseña correctamente!")
                $("#msg").show("slow").find(".msgcon").text(msg);

                $("#inputCUIT").focus()
                e.prevenDefault();
            }			
		});
		
					
	})
</script>


</body>
</html>