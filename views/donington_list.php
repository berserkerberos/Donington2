  
<?php
require_once  $_SERVER['DOCUMENT_ROOT'] .'/views/header.inc.view.php';
?>

<script>

$(function(){

  $("#consulta_trans").on("click",function(){
      
      $("#accion").val("listtransferencia");   
      $("#entrega").val($("#cbEntregas").val());      
      $("#form").submit();

  })

  $("#descargar_entre").on("click",function(){
      $("#accion").val("descarga_entre");   
      $("#entrega").val($("#cbEntregas").val());      
      $("#form").submit();

  })

})

</script>

<form id="form" action="donington.php" method="POST" enctype="multipart/form-data" >
<input type="hidden" id="accion" name="accion" value="" />
<input type="hidden" id="entrega" name="entrega" value="" />
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
     	
        <h1>Listado de transferenacias por entrega</h1>
        <hr>
        <div class="pull-left">
          <div class="row">
              <div class="col-sm-12">
                  <?php
                  //var_dump($entr);
                  ?>
                  <select name="cbEntregas" id="cbEntregas" class="form-control" style="width:100%" >
                      <option value="0">--Seleccionar--</option>
                      <?php                        
                        foreach ($entr as $key => $value) {                          
                          echo '<option '.($entrega == $value["entrega"] ? "selected" : "" ) .' value="'.$value["entrega"].'" >'.$value["entrega"].'</option>';
                        }
                      ?>
                  </select>    
              </div>
          </div>
          
        </div>

        <div class="pull-right">
          <div class="btn btn-info" id="consulta_trans" >Buscar</div>
          <div class="btn btn-success" id="descargar_entre"  >Descargar</div>
        </div>
     		
         </br>
         </br>
         
         <?php
         //Helper::dd($trans,"resultado");

         ?>

        <table class="table table-responsive table-striped table-bordered table-sm">
        <thead class = "thead-dark">
      
          <tr>
          <th>entrega</th>
            <th>id</th>
            <th>Fecha</th>
            <th>Cbu. Debito</th>
            <th>Cbu. Credito</th>
            <th>Alias CBU  Debito</th>
            <th>Alias CBU Credito</th>
            <th>Importe</th>
            <th>Concepto</th>
            <th>Motivo</th>
            <th>Referencia</th>
            <th>Email</th>
            <th>Titular</th>
          </tr>
        </thead>
        <tbody>
        <?php
        foreach ($trans as $key => $value) {
          echo "<tr>";
          echo "<td>". $value["entrega"] ."</td>";
          echo "<td>". $value["id"] ."</td>";
          echo "<td>". $value["Fecha"] ."</td>";
          echo "<td>". $value["CBU_DEBITO"] ."</td>";
          echo "<td>". $value["CBU_CREDITO"] ."</td>";
          echo "<td>". $value["ALIAS_CBU_DEBITO"] ."</td>";
          echo "<td>". $value["ALIAS_CBU_CREDITO"] ."</td>";
          echo "<td>". $value["IMPORTE"] ."</td>";
          echo "<td>". $value["CONCEPTO"] ."</td>";
          echo "<td>". $value["MOTIVO"] ."</td>";
          echo "<td>". $value["REFERENCIA"] ."</td>";
          echo "<td>". $value["EMAIL"] ."</td>";
          echo "<td>". $value["TITULARES"] ."</td>";
         
                    echo "</tr>";
        }
        ?>
        </tbody>
        </table>


      </section>
<!-- /.content -->



</form>


<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/footer.inc.view.php';
?>