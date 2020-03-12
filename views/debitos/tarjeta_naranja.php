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
	<input type="hidden" value="tarjeta_naranja" id="tipo_export" name="tipo_export" >
    <div class="container">        

<?php
if ($mensaje["tipomsg"] != "") {
    Helper::printMensaje($mensaje["msg"], $mensaje["tipomsg"]);
}
?>

        <h1>Tarjeta Naranja </h1>
        <p>Genera txt de exportación para informar las facturas a cobrar por este servicio</p>
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
                    <label for="">Fecha de archivo</label>
                    <input type="date" name="txFechaArchivo" class="form-control" >
                </div>

                <div class="col-sm-3">
                    <label for="">Fecha de vencimiento del débito</label>
                    <input type="date" name="txFechaVencimiento" class="form-control" >
                </div>

                <div class="col-sm-3">
                    <label for="">Cod de tarjeta</label>
                    <input type="number" name="txCod" class="form-control" maxlength="8"  minlength="8" value="265036145" placeholder="9 dígitos" >
                </div>
                
                <div class="col-sm-4">
                    <label for="">Mes de factura</label>
                    <input type="date" name="txConcepto" class="form-control" placeholder="mes y año (mm/yyyy)" >
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