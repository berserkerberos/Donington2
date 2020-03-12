  
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/header.inc.view.php';
?>

<form id="form" action="factura.php" method="POST"
	enctype="multipart/form-data">

<!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Mis datos
        </h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/controllers/inicio.php"><i class="fa fa-dashboard"></i>
              Home</a></li>
          <li class="breadcrumb-item active">Consulta</li>
        </ol>
        <hr />
      </section>

      <!-- Main content -->
      <section class="content">




	<input type="hidden" id="accion" name="accion" value="" />

		
		<div class="card">
		  <h5 class="card-header">
		    Datos registrados en la empresa:
		  </h5>
		  <div class="card-body">


		<ul class="list-group">
			<li class="list-group-item">Cuit: 20999999991
          					
          </li>
			<li class="list-group-item">Contraseña: <a
				href="/controllers/login.php"
				class="btn btn-sm btn-info" id=""><span
					data-feather="lock"></span> Pedir cambio de Contraseña </a>
			</li>
			<li class="list-group-item">Dirección de Mail: farmacia@proveedor.com.ar
          </li>
			<li class="list-group-item">Teléfono de contacto: 0114564564564
          </li>
			<li class="list-group-item">Tipo proveedor: Farmacia          
          </li>
		</ul>

		  </div>
		</div>



      </section>
<!-- /.content -->
		
      


</form>


<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/footer.inc.view.php';
?>