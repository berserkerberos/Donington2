  
<?php
require_once  $_SERVER['DOCUMENT_ROOT'] .'/views/header.inc.view.php';
?>

<script>

$(function(){

  $("#btnProcesar").on("click",function(){
  // var validad = validar();
  //if (validaD){
      // sigue y envia el form por post
      $("#accion").val("PROCESAR");
      $("#form").submit();

  //}
  });


})

</script>

<form id="form" action="donington.php" method="POST" enctype="multipart/form-data" >
    <input type="hidden" id="accion" name="accion" value="" />
<!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Formulario Donington
        </h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/controllers/inicio.php"><i class="fa fa-dashboard"></i>
              Inicio</a></li>          
        </ol>
      </section>


      <!-- Main content -->
      <section class="content">

      
      <?php
                        if ($mensaje["tipomsg"] != "") {
                            Helper::printMensaje($mensaje["msg"], $mensaje["tipomsg"]);
                        }
                        ?>
     	
      <div class="card" style="padding:15px">
            
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Indicar N°de entrega</label>
                    <input type="number" name="txNumEntrega" class="form-control" maxlength="12"  minlength="12" placeholder="N° Entrega" >
                     
                </div>
                <div class="col-sm-3">
                    <label for="">Fecha</label>
                    <input type="date" name="txFecha" class="form-control" >
                </div>

                <div class="col-sm-3">
                    <label for="">CBU Debito</label>
                    <input type="number" name="txCbuDebito" class="form-control" maxlength="22"  
                    minlength="22" placeholder="22 caracteres" value="" >
                </div>

                <div class="col-sm-3">
                    <label for="">CBU Credito</label>
                    <input type="number" name="txCbuCredito" class="form-control" maxlength="22"  
                    minlength="22" placeholder="22 caracteres" value="" >
                </div>
                <div class="col-sm-3">
                    <label for="">Titulares</label>
                    <input type="number" name="txCbuDebito" class="form-control" maxlength="22"  
                    minlength="22" placeholder="1 caracteres" value="" >
                </div>

                <div class="col-sm-3">
                    <label for="">Alias CBU Debito</label>
                    <input type="text" name="txAliascbuDeb" class="form-control" maxlength="22"  
                    minlength="22" placeholder="22 caracteres" value="" >
                </div>
                
                <div class="col-sm-4">
                    <label for="">Alias Cbu Credito</label>
                    <input type="text" name="txAliasCbuCred" class="form-control" maxlength="22"  minlength="22" placeholder="22 caracteres" >
                     
                </div>
                <div class="col-sm-4">
                    <label for="">Importe</label>
                    <input type="number" name="txImporte" class="form-control" maxlength="20"  minlength="20" placeholder="22 caracteres" >
                </div>
                <div class="col-sm-4">
                    <label for="">Concepto</label>
                    <input type="text" name="txConcepto" class="form-control" maxlength="50"  minlength="50" placeholder="50 caracteres" >
                </div>
                <div class="col-sm-4">
                    <label for="">Motivo</label>
                    <input type="text" name="txMotivo" class="form-control" maxlength="20"  minlength="20" placeholder="100 caracteres" >
                </div>
                <div class="col-sm-4">
                    <label for="">Referencia</label>
                    <input type="text" name="txReferencia" class="form-control" maxlength="12"  minlength="12" placeholder="12 caracteres" >
                </div>
                <div class="col-sm-4">
                    <label for="">Email</label>
                    <input type="email" name="txEmail" class="form-control" maxlength="40"  minlength="40" placeholder="50 caracteres" >
                </div>
                <div class="col-sm-4">
                    <label for="">Importe</label>
                    <input type="number" name="txImporte" class="form-control" maxlength="12"  minlength="12" placeholder="12 caracteres" >
                </div>

            </div>

        </div>

        <hr />
        <div id="btnProcesar" class="btn btn-info" >Procesar</div>
      		
      </section>
<!-- /.content -->



</form>


<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/footer.inc.view.php';
?>