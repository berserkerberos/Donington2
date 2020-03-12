<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../images/favicon.ico">

<title>Donington </title>

<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>window.jQuery || document.write('<script src="../js/jquery-3.3.1.min.js"><\/script>')</script>

  <!-- popper -->
  <script src="../js/popper.min.js"></script>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<script type="text/javascript" src="../js/bootstrap.min.js"></script>

<!-- Bootstrap 4.0
<link rel="stylesheet"
	href="../assets/vendor_components/bootstrap/dist/css/bootstrap-extend.css">
-->

<!-- theme style -->
<link rel="stylesheet" href="../css/master_style.css">
<!-- apro_admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="../css/skin-black.css">
<!-- font awesome -->
<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.css">
<!-- ionicons -->
<link rel="stylesheet" href="../css/Ionicons/css/ionicons.css">

<!-- Custom styles for this template -->

<style type="text/css">
.table td, .table th {
	padding: .25rem;
	text-align: left;
}

.alert {
	position: fixed;
	left: 55%;
	transform: translateX(-50%);
	width: 50%;
	z-index: 100;
}

</style>
</head>

<?php
$usuarioLogueado = unserialize($_SESSION['USUARIO']);
//Helper::dd($usuarioLogueado,"usuario");
?>

<body class="hold-transition sidebar-mini sidebar-open skin-black">
	<div class="wrapper">

		<header class="main-header">
			<!-- Logo -->
			<a href="#" class="logo"> <!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><img src="../images/logo1.png" style="height: 50px;width: 50px;"  alt=""></span> <!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>Donington</b>Tranferencias</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu"
					role="button"> <span class="sr-only">Toggle navigation</span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu"><a href="#"
							class="dropdown-toggle btn btn-grey" data-toggle="dropdown"> Datos de Usuario 
						</a>
							<ul class="dropdown-menu scale-up">
								<!-- User image -->
								<li class="user-header">
									<div style="padding: 10px" >
										<?php  echo utf8_encode($usuarioLogueado->getNombreCompleto()); ?>
										<small class="mb-5"><?php  echo utf8_encode($usuarioLogueado->getMaquina()); ?></small>										
									</div>
								</li>
								<!-- Menu Body -->
<!-- 								<li class="user-body">
									<div class="row no-gutters">
										<div class="col-12 text-left">
											<a href="/controllers/misdatos.php"><i class="ion ion-person"></i> Mi perfil</a>
										</div>
									</div>
								</li> -->
								<!-- Menu Footer-->
								<li class="user-footer">
<!-- 									<div class="pull-left"> -->
<!-- 										<a href="#" class="btn btn-block btn-primary"><i -->
<!-- 											class="ion ion-locked"></i> Lock</a> -->
<!-- 									</div> -->
									<div class="pull-right">
										<a href="/controllers/logout.php" class="btn btn-block btn-danger"><i
											class="ion ion-power"></i> Cerrar Sesion</a>
									</div>
								</li>
							</ul></li>
					
						    <?php
                            // require_once $_SERVER['DOCUMENT_ROOT'] .'/views/header.inc.view.mensajes.php';
                            ?>
					</ul>
				</div>
			</nav>
		</header>

		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu" data-widget="tree">

					
				<li class=""><a href="/controllers/donington.php"> <i
							class="fa fa-laptop"></i> <span>Formulario</span> <span
							class="pull-right-container"> 
						</span>
					</a></li>
					

					
					<li class=""><a href="/controllers/donington.php?accion=listtransferencia"> <i
							class="fa fa-laptop"></i> <span>Consultas</span> <span
							class="pull-right-container"> 
						</span>
					</a></li>
					
				</ul>	
			</section>
			<!-- /.sidebar -->

		</aside>


		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
		