  
<?php
require_once  $_SERVER['DOCUMENT_ROOT'] .'/views/header.inc.view.php';
?>

<form id="form" action="factura.php" method="POST" enctype="multipart/form-data" >
     



<!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Bienvenido 
        </h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/controllers/inicio.php"><i class="fa fa-dashboard"></i>
              Inicio</a></li>          
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
     	
     		<h1>Herramienta de Transferencia Masiva</h1>
      		
      </section>
<!-- /.content -->



</form>


<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/footer.inc.view.php';
?>