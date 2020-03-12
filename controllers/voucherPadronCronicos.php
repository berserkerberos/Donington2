<?php
require_once ('../header.inc.php');

if (! empty($_REQUEST["accion"])) {
    
    switch ($_REQUEST["accion"]) {
        case "PROCESAR":
            
            // ob_clean();
            // header("Content-type: text/plain");
            // header("Content-Disposition: attachment; filename=pagomiscuentas.txt");
            $mes = $_REQUEST["txmes"];
            $dni = $_REQUEST["txdni"];
            $resultadotxt = "";
            $resultadotxt = procesar();
            
            // echo $resultadotxt;
            // die;
            
            break;
        default:
            echo "No se pudo determinar la acción";
    }
}

function procesar()
{
    $resultadotxt = "";
    try {
        
        if (! extension_loaded('odbc')) {
            die('ODBC extension not enabled / loaded');
        }
        
        $iniFile = ROOT_PATH . "/backend/config/configDBSAP.ini";
        $data = parse_ini_file($iniFile, true);
        
        
        $driver = $data["DB_EJEMPLO"]["db_driver"];
        $host = $data["DB_EJEMPLO"]["db_string"];
        $db_name = $data["DB_EJEMPLO"]["db_name"];
        $username = $data["DB_EJEMPLO"]["db_usr"];
        $password = $data["DB_EJEMPLO"]["db_pass"];
        $MANDANTE = $data["DB_EJEMPLO"]["db_mandante"];
        
        /*
        $host = "10.1.54.27:30415";
        $db_name = "HDB";
        $username = 'USER_QUERY_OLMOS';
        $password = "O4q_olmos02";
        $MANDANTE = "200";
        **/
        /*
         * $usuario_update = "USER_MODIF_TABLA";
         * $password_update = "Usertabla18";
         * $username = $usuario_update;
         * $password = $password_update;
         */
        
        // echo "Conexion: Driver=$driver;ServerNode=$host;Database=$db_name;";
        $conn = odbc_connect("Driver=$driver;ServerNode=$host;Database=$db_name;", $username, $password, SQL_CUR_USE_ODBC);
        
        if (! $conn) {
            // Try to get a meaningful error if the connection fails
            echo "Connection failed.\n";
            echo "ODBC error code: " . odbc_error() . ". Message: " . odbc_errormsg();
        } else {
            
            if (empty($_REQUEST["txdni"])) {
                throw new Exception("Complete el dni", 1);
            }
            
            if (empty($_REQUEST["txmes"])) {
                throw new Exception("Complete el mes de entrega", 1);
            }
            
            $dni = $_REQUEST["txdni"];
            $mes = explode("-", $_REQUEST["txmes"])[0] . explode("-", $_REQUEST["txmes"])[1];
            
            $sql = "				

select  a.dni,
a.cantidad_s_presentacion,
a.descuento,
a.comentario,
a.observacion,
a.farmacia,
b.MAKTX,
b.MATNR,
concat(concat( c.APELLIDO , ' '),c.NOMBRE) as nom_completo,				
c.FECHA_NACIMIENTO,
concat(anio_inicio,mes_inicio)  as mes_ini,
concat(anio_final,mes_final)  as mes_fin,
d.ddtext,
WGBEZ

from sapabap1.ZMM_PADRON_MEDI  as a
inner join sapabap1.makt as b on a.matnr = b.matnr
	inner join sapabap1.mara as f on f.matnr = b.matnr
		inner join sapabap1.T023T as g  on f.MATKL = g.MATKL
inner join sapabap1.ZMM_PADRON_UOM as c on a.dni = c.dni
left outer join sapabap1.dd07t as d on cast(a.farmacia as int) = cast(d.domvalue_l as int) and d.domname = 'Z_FARMACIA' and d.ddlanguage = 'S'                
where cast( a.dni as int) = '" . intval($dni) . "'				
and ('" . $mes . "' >= concat(anio_inicio,mes_inicio) and '" . $mes . "' <= concat(anio_final,mes_final))
and a.mandt = " . $MANDANTE . "
and b.mandt = a.mandt
and b.spras = 'S'
and c.mandt = a.mandt
and a.estado = 'A'  			  				
				
				";
			
			//Helper::dd($sql,"consulta");
			//exit;
            $result = odbc_exec($conn, $sql);
            if (! $result) {
                echo "Error while sending SQL statement to the database server.\n";
            } else {
                $resultadotxt = "";
                $arr_result = [];
				//echo "paso111";
				//Helper::dd($result,"result");
                while ($row = odbc_fetch_array($result)) {
                    //Helper::dd($row,"fila");
                    $cantidadMeses = $row["MES_FIN"] - $row["MES_INI"] + 1;
					//echo "paso2222";
					//echo $cantidadMeses;
					//exit;
					$cronograna = [];
                    for ($i = $cantidadMeses; $i > 0; $i --) {
                        $leSobra = 0;
                        $cantidad = $row["CANTIDAD_S_PRESENTACION"];
                        if (count($cronograna) > 0) {
                            $leSobra = $cronograna["m" . ($i + 1)]["darle"] - $cronograna["m" . ($i + 1)]["necesita"];
                            $cantidad = $cronograna["m" . ($i + 1)]["cantidad"] - $cronograna["m" . ($i + 1)]["darle"];
                        }
                        $crono = [
                            "cantidad" => $cantidad,
                            "mes_rest" => $i,
                            "le_sobra" => $leSobra,
                            "necesita" => ($cantidad / $i) - $leSobra,
                            "darle" => ceil(($cantidad / $i) - $leSobra),
                            "mes" => ($row["MES_FIN"] - $i + 1)
                        ];
                        $cronograna["m" . $i] = $crono;
                    }
                    
                    $row["cronograma"] = $cronograna;
                    $arr_result[] = $row;
                }
                
                // $resultadotxt = var_export($arr_result);
                $resultadotxt = $arr_result;
            }
            odbc_close($conn);
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">';
        echo "Erro general sin controlar: " . $e->getMessage();
        echo '</div>';
    }
    
    return $resultadotxt;
}

?>




<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>window.jQuery || document.write('<script src="../js/jquery-3.3.1.min.js"><\/script>')</script>

<!-- Bootstrap core CSS -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
	integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
	crossorigin="anonymous">
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
	integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
	crossorigin="anonymous"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
	integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
	crossorigin="anonymous"></script>


<script>
        $(function(){

            $("#btnProcesar").on("click",function(e){                
                $("#accion").val("PROCESAR");
                $("#form1").submit();
                e.preventDefault();
            });

    		$("#btnPrint").on("click",function() {    	
    			var printContents = document.getElementById('comprobante').innerHTML;
    			var originalContents = document.body.innerHTML;
    			document.body.innerHTML = printContents;
    			window.print();
    			document.body.innerHTML = originalContents;
    			window.location.href = 'voucherPadronCronicos.php'; 									
			});	


    		/*
    		setTimeout(function(){ 

    			if($('#btnPrint').is(':visible')){
                	$("#btnPrint").click();
                }
        	}, 500);           
				**/            
				
        })
    </script>
<style>
.table-bordered td, .table-bordered th {
	padding-top: 2px;
	padding-bottom: 2px;
}
</style>
</head>
<body>

	<form action="voucherPadronCronicos.php" id="form1" action="POST">
		<input type="hidden" value="" id="accion" name="accion">

		<div class="container">

			<h1>Impresion de voucher</h1>
			<p>Genera el voucher para retirar la medicación, de los pedidos
				autorizados en el padron de afliados crónicos</p>
			<div class="card" style="padding: 15px">

				<div class="row">
					<div class="col-sm-3">
						<label for="">Dni</label> <input type="number" name="txdni"
							class="form-control"
							value="<?php echo (!empty($dni) ? $dni : null);  ?>">
					</div>
					<div class="col-sm-3">
						<label for="">Mes a entregar</label> <input type="date"
							name="txmes" class="form-control"
							value="<?php echo (!empty($mes) ? $mes : null);  ?>">
					</div>

				</div>

			</div>

			<hr />
			<button id="btnProcesar" class="btn btn-info">Procesar</button>
			<a id="btnLimpiar" class="btn btn-info"
				href="voucherPadronCronicos.php">Limpiar</a>

<br>
<br>
			<div id="comp">

<?php

if (! empty($resultadotxt)) :
    $i = $resultadotxt[0];
    //Helper::dd($resultadotxt, "resultado return");
    ?>


				<div class="card" style="" id="cronograma">

					<div class="card-header">
                        Cronograma de Medicación a entregar
                    </div>
					<div class="card-body">
						<div>
							<div class="row">
								<div class="col-12">									
									<table class="table table-bordered" style="font-size: 14px" >
										<thead>
											<tr>
												<td style="">Cod material</td>
												<td style="">Descripcion</td>
												<td style="">Descuento</td>
												<td style="">Cantidad por entregar</td>
												<td style="">Farmacia</td>
												<td>Grupo de compra</td>
											</tr>
										</thead>
										<tbody>
								
									<?php
    
    foreach ($resultadotxt as $item) :
        ?>
    								<tr>
												<td style="text-align: right"><?php echo intval($item["MATNR"])?></td>
												<td><?php echo utf8_encode($item["MAKTX"])?></td>
												<td style="text-align: right"><?php echo intval($item["DESCUENTO"] ) . "%" ;?></td>
												<td style="text-align: right">
												
												
													<div>
														<table class="table table-bordered" style="font-size: 12px;margin: 0px;" >
                										<thead>
                											<tr>
                												<td style="">Cantidad</td>                												
                												<td style="">Hay que darle</td>
																<td style="">Mes</td>
                											</tr>
                										</thead>
                										<tbody>

															
															<?php
															foreach($item["cronograma"] as $entrega){

															?>

																<tr>
																	<td><?php echo intval($entrega["cantidad"]) ?></td>																	
																	<td><?php echo $entrega["darle"] ?></td>
																	<td><?php echo $entrega["mes"] ?></td>																	
																</tr>

															<?php	
															} 
															
															?>
                											
                										</tbody>                										
                										</table>                										
													</div>
												
    									</td>
												<td>
    										<?php echo($item["DDTEXT"]);?>
    									</td>
										<td>
											<?php echo utf8_encode($item["WGBEZ"])?>
										</td>
											</tr>		
		<?php
    endforeach
    ;
    ?>									
								</tbody>
									</table>
								</div>
							
							</div>

						</div>

						
					</div>
				</div>

   <br>
   <br>
<button id="btnPrint" class="btn btn-success">Imprimir</button>

				<div class="card" style="" id="comprobante">

					<div class="card-body">
						<div>
							<div class="row">
								<div class="col-6">
									<div class="text-center">
										<img src="../../images/logo_red_basa.png" alt="" />
									</div>

								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-12" style="font-size: 20px">																	
									AFILIADO: <?php echo($i["NOM_COMPLETO"]) ?>  
									<br /> 
									DNI: <?php echo($i["DNI"])?>
								</div>
									</div>
								</div>

							</div>
							<hr>
							<div class="row">
							
								<div class="col-6"  style="font-size: 20px;">Fecha de comprobante: (<?php echo date('d/m/Y');?>) </div>
								<div  class="col-6" style="font-size: 20px;text-align: right;">Mes de entrega: (<?php echo  substr('2019-04-10',0,7) ;?>) </div>
								<div class="col-12">
									<br />
									<table class="table table-bordered">
										<thead>
											<tr>
												<td style="">Cod material</td>
												<td style="">Descripcion</td>
												<td style="">Descuento</td>
												<td style="">Cantidad por entregar</td>
												<td style="">Farmacia</td>
												<td style="">Grupo de compra</td>
											</tr>
										</thead>
										<tbody>
								
									<?php
    
    foreach ($resultadotxt as $item) :
        ?>
    								<tr>
												<td style="text-align: right"><?php echo intval($item["MATNR"])?></td>
												<td><?php echo utf8_encode($item["MAKTX"])?></td>
												<td style="text-align: right"><?php echo intval($item["DESCUENTO"] ) . "%" ;?></td>
												<td style="text-align: right">
    									<?php
        foreach ($item["cronograma"] as $meses) {
            if ($meses["mes"] == explode("-", $mes)[0] . explode("-", $mes)[1]) {
                echo $meses["darle"];
            }
        }
		?>
												</td>
														<td>
													<?php echo($item["DDTEXT"]);?>
												</td>
												<td>
													<?php echo utf8_encode($item["WGBEZ"])?>
												</td>
									</tr>		
    								<?php
    endforeach
    ;
    ?>									
								</tbody>
									</table>
								</div>
								<div class="col-sm-12">
									<div class="row">
										
										<div class="col-sm-12">
											<div style="text-align:left; padding-top: 50px">
												<p>..........................................................................................</p>
												<p>Responsable de Seccional</p>		
											</div>
										</div>

										<div class="col-sm-12">
											<div style="text-align: left; padding-top: 50px">
												<p>..........................................................................................</p>
												<p>Recibí conforme</p>
											</div>
										</div>

									</div>
								</div>
							</div>

						</div>

						<p style="text-align: center; padding-top: 10px">(Este comprobante no tiene validez legal como factura)</p>
					</div>
				</div>
<?php 
    endif;

?>
	
	</div>

		</div>
	</form>




</body>
</html>
