<?php
require_once  $_SERVER['DOCUMENT_ROOT'] .'/views/header.inc.view.php';
?>
<script>
  $(function(){     

    $("#btnProcesar").on("click",function(e){                
                $("#accion").val("PROCESAR");
                $("#form1").submit();
                e.preventDefault();
    });
        
  });
</script>




<form action="exportaciones.php" id="form1" action="POST">
    <input type="hidden" value="" id="accion" name="accion" >    
	<input type="hidden" value="HSBC_GSGA" id="tipo_export" name="tipo_export" >
    <div class="container">        

        <h1>Debito Gallego HSBC</h1>
        <p>Genera txt de exportación para informar las facturas a cobrar por este servicio</p>


<?php
    if ($mensaje["tipomsg"] != "") {
        echo Helper::printMensaje($mensaje["msg"], $mensaje["tipomsg"]);          
    }
?>


        <div class="card" style="padding:15px">
            
            <div class="row">


				<div class="col-sm-3">
                    <label for="">Fecha Desde</label>
                    <input type="date" name="txFechaDesde" class="form-control" >
                </div>
                <div class="col-sm-3">
                    <label for="">Fecha Hasta</label>
                    <input type="date" name="txFechaHasta" class="form-control" >
                </div>


                <div class="col-sm-3">
                    <label for="">Fecha de la Presentación</label>
                    <input type="date" name="txFechaVencimiento" class="form-control" >
                </div>

                <div class="col-sm-3">
                    <label for="">Cod de tarjeta</label>
                    <input type="number" name="txCod" class="form-control" maxlength="11"  minlength="11" value="66365810009" placeholder="9 dígitos" >
                </div>
                
                                

            </div>

        </div>

        <hr />
        <div id="btnProcesar" class="btn btn-info" >Procesar</div>
        <div class="card">            
            <?php // echo (empty($resultadotxt)? "" :  $resultadotxt) ; ?>
        </div>
    </div>
</form>






<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/footer.inc.view.php';
?>