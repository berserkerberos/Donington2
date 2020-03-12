<?php
require_once ('../header.inc.php');

if (! empty($_REQUEST["accion"])) {
    
    switch ($_REQUEST["accion"]) {
        case "PROCESAR":            
            // ob_clean();
            // header("Content-type: text/plain");
            // header("Content-Disposition: attachment; filename=pagomiscuentas.txt");            
			$dni = $_REQUEST["txdni"];
			$pin = $_REQUEST["txpin"];
			$nombre = $_REQUEST["txnombre"];
			$fecdesde = $_REQUEST["txfechadesde"];
			$fechasta = $_REQUEST["txfechahasta"];			
			$secc =  $_REQUEST["cbSeccional"];			
            $resultadotxt = "";
            $resultadotxt = procesar();            
            // echo $resultadotxt;
            // die;            
			break;
		case "INGRESAR":				
			$usu = $_REQUEST["txusu"];
			$pass = $_REQUEST["txpass"];
			$resulLoguin =  controlaLogin($usu,$pass);
			//Helper::dd($resulLoguin,"resultado");			

			$fecdesde = date('Y-m-d');
			$fechasta = date('Y-m-d');

			break;
		case "SALIR":				
			$_SESSION["login_ok"] =  "";		
			session_destroy();			
			header('Location: /controllers/reloj.php');
			break;
		case "EXPORTAR":				
		
			//ob_clean();
            //header("Content-type: text/plain");
            //header("Content-Disposition: attachment; filename=reloj.xls");            
			exportarResultado();
			die();
			break;
        default:
            echo "No se pudo determinar la acción";
    }
}

function darConexion(){

	/*$iniFile = ROOT_PATH . "/backend/config/configDBSAP.ini";
	$data = parse_ini_file($iniFile, true);
	
	
	$driver = $data["DB_EJEMPLO"]["db_driver"];
	$host = $data["DB_EJEMPLO"]["db_string"];
	$db_name = $data["DB_EJEMPLO"]["db_name"];
	$username = $data["DB_EJEMPLO"]["db_usr"];
	$password = $data["DB_EJEMPLO"]["db_pass"];
	$MANDANTE = $data["DB_EJEMPLO"]["db_mandante"];
	**/
					
	$host = "192.168.2.103";
	$port= "";
	$db_name= "ZKAccess";
	$username ="admambulatorio";
	$password ="ushuaia";
	$db = "";
	
	if (! extension_loaded('pdo_odbc')) {
		die('ODBC extension not enabled / loaded');
	}

	try {

		//$db = new PDO ("dblib:host=$hostname:$port;dbname=$dbname", "$user", "$pwd");
		//$db = new PDO ("mssql:host=$hostname:$port;dbname=$dbname", "$user", "$pwd");
		$db = new PDO("odbc:Driver={SQL Server};Server=$host;Database=$db_name;", "$username", "$password");					
		//code...
	} catch (\Throwable $th) {
		//throw $th;
	}
	

	if (! $db) {
		// Try to get a meaningful error if the connection fails
		echo "Connection failed.\n";
		echo "ODBC error code: " . odbc_error() . ". Message: " . odbc_errormsg();
		die();	
	}
	return $db;

}

function controlaLogin($usu,$pass){

	/*
	if ($usu = "adm" && $pass =  "adm"){
		$_SESSION["login_ok"] =  true;				
	}else{
		$_SESSION["login_ok"] =  false;
	}
	**/

	$resul = false;
	try {



		$db = darConexion();        		

		/**********************  las seccionales*/
		$sql = "  	select distinct MachineAlias from Machines ";				
		$stmt = $db->prepare($sql);
		$stmt->execute();
		//Helper::dd($sql,"consulta")	;
		$seccionales = [];		
		do {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $rst)
			{				
				$seccionales[] = $rst["MachineAlias"];														
			}
		} while ($stmt->nextRowset());	
		
		/*********************** */

		$sql = "  
		  select id, username,Status,RoleID,Remark 
		  from auth_user as a where 1=1 ";
		$sql .= " and a.username = '" . $usu. "'";
		$sql .= " and a.password = '" . $pass."'";			
		
		$stmt = $db->prepare($sql);
		$stmt->execute();
		//Helper::dd($sql,"consulta")	;
		$resultadotxt = [];		
		do {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $rst)
			{
				if($rst["id"] == "1"){
					$_SESSION["login_ok"] = $rst;
					$_SESSION["login_ok"]["secc"] = $seccionales;					
				}else{
					$_SESSION["login_ok"] = $rst;
					$_SESSION["login_ok"]["secc"] = explode( ",",$rst["Remark"]);													
				}	
				$resul =  true;					
			}
		} while ($stmt->nextRowset());	
		
		$db = null;	

	} catch (\Throwable $th) {
		//throw $th;
	}

	return $resul;
	
}

function procesar(){
    $resultadotxt = "";
    try {        		
		$db = darConexion();        		
		
		/*if (empty($_REQUEST["txdni"])) {
			throw new Exception("Complete el dni", 1);
		}**/
		
		$dni = (empty($_REQUEST["txdni"])? "" : $_REQUEST["txdni"] ) ;
		$pin = (empty($_REQUEST["txpin"])? "" : $_REQUEST["txpin"] ) ;
		$nombre = (empty($_REQUEST["txnombre"])? "" : $_REQUEST["txnombre"] );
		$fecdesde = (empty($_REQUEST["txfechadesde"])? "" : $_REQUEST["txfechadesde"] );
		$fechasta = (empty($_REQUEST["txfechahasta"])? "" : $_REQUEST["txfechahasta"] );			
		$secc = (empty($_REQUEST["cbSeccional"])? "" : $_REQUEST["cbSeccional"]);			
		
		$sql = "
		
		select a.Name, b.state,  CONVERT( VARCHAR(10), b.time, 111) + ' ' + CONVERT(VARCHAR(8), b.time, 108) as time , b.pin, a.identitycard, CONVERT( VARCHAR(10), b.time, 111) AS DIA,device_name
		from userinfo as a
		inner join acc_monitor_log as b on a.badgenumber = b.pin 
		where 1=1
		";

		$sql .= (empty($dni) ? "" : " and a.identitycard = " . $dni);
		$sql .= (empty($pin) ? "" : " and b.pin = " . $pin);
		$sql .= (empty($nombre) ? "" : " and a.Name like '" . $nombre . "'");
		$sql .= (empty($fecdesde) ? "" : " and  CONVERT( VARCHAR(10), b.time, 023) >= '" . $fecdesde. "'");
		$sql .= (empty($fechasta) ? "" : " and  CONVERT( VARCHAR(10), b.time, 023) <= '" . $fechasta."'");			
		

		if (empty($secc)){
			$tmpsecc= "";
			foreach ($_SESSION["login_ok"]["secc"] as $key => $value) {				
				$tmpsecc .= "'" . $value . "',";
			}	
			$tmpsecc = substr($tmpsecc,0,strlen($tmpsecc) - 1);		
			$sql .=  "and  device_name in (" . $tmpsecc.  ")";							
		}else{
			$sql .= (empty($secc) ? "" : " and  device_name = '" . $secc.  "'");			
		}
		

		$sql .= " ORDER BY b.pin, dia DESC, b.state ASC ";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$_SESSION["query"] = $sql;
		//Helper::dd($sql,"consulta")	;
		$resultadotxt = [];
		
		do {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $rst)
			{
				$resultadotxt[] =  $rst;										
			}
		} while ($stmt->nextRowset());	
		
		$db = null;
	
        
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">';
        echo "Erro general sin controlar: " . $e->getMessage();
        echo '</div>';
    }
    
    return $resultadotxt;
}

function exportarResultado(){
	if(!empty($_SESSION["query"])){
		$db = darConexion();        		
		$sql = $_SESSION["query"];
		$stmt = $db->prepare($sql);
		$stmt->execute();
		
		$result_arr = [];
		
		do {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $rst){
				array_push($result_arr,$rst);										
			}
		} while ($stmt->nextRowset());	
		$db = null;
		Helper::escribirCSV($result_arr,"export.xls",false);					
	}
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

            $("#btnIngresar").on("click",function(e){                
                $("#accion").val("INGRESAR");
                $("#form1").submit();
                e.preventDefault();
            });		
        })
    </script>
<style>
.table-bordered td, .table-bordered th {
	padding-top: 2px;
	padding-bottom: 2px;
}

/* Set a background image by replacing the URL below */
body {
  background: url('https://www.freejpg.com.ar/image-900/95/9587/F100005261-atardecer_fondo_background_otono_hoja_hojas.jpg') no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  background-size: cover;
  -o-background-size: cover;
}

</style>
</head>
<body>

	<form action="reloj.php" id="form1" action="POST">
		<input type="hidden" value="" id="accion" name="accion">



<nav class="navbar navbar-expand-lg navbar-light bg-light static-top mb-5 shadow">
  <div class="container">
    <a class="navbar-brand" href="#">
		Control de reloj
	</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">


	  		<?php 
			if (!empty($_SESSION["login_ok"])) : 
			?>
			<li class="nav-item active">				
				<div class="nav-link">
					<span style="padding-right: 20px;" >Usuario: <?php echo $_SESSION["login_ok"]["username"];?></span>
					<a href="/controllers/reloj.php?accion=SALIR" class="btn btn-danger btn-sm">Salir de sistema</a>
				</div>
				
			</li>

			<?php 
			endif;
			?>

      </ul>
    </div>
  </div>
</nav>

<!-- Page Content -->
<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
 
		<?php 
		if (empty($_SESSION["login_ok"])) : 			
		?>

		<div class="container">
			<div class="login">
				<div class="row">
					<div class="col-sm-3"></div>					
					<div class="col-md-6">					
						<label for="">Usuario</label> 
						<input type="text" name="txusu" class="form-control" value="">
						<label for="">Password</label> 
						<input type="password" name="txpass" class="form-control" value="">
						<br>
						<button type="button" class="btn btn-info" id="btnIngresar" >Ingresar</button>

					</div>
					<div class="col-sm-3"></div>
				</div>
			</div>
		</div>
		<?php
		else:
			//Helper::dd($_SESSION["login_ok"],"login");		
		?>
		<div class="container">
			<h3>Complete algunos de los filtros</h3>
			<hr>
			<div class="card" style="padding: 15px">

				<div class="row">
					<div class="col-sm-2">
						<label for="">Dni</label> 
						<input type="number" name="txdni"
							class="form-control"
							value="<?php echo (!empty($dni) ? $dni : null);  ?>">
					</div>
					<div class="col-sm-2">
						<label for="">Pin</label> 
						<input type="number" name="txpin"
							class="form-control"
							value="<?php echo (!empty($pin) ? $pin : null);  ?>">
					</div>
					<div class="col-sm-2">
						<label for="">Nombre</label> 
						<input type="text" name="txnombre"
							class="form-control"
							value="<?php echo (!empty($nombre) ? $nombre : null);  ?>">
					</div>
					<div class="col-sm-3">
						<label for="">Fecha</label> 
						<input type="date"
							name="txfechadesde" class="form-control"
							value="<?php echo (!empty($fecdesde) ? $fecdesde : null);  ?>">
						<input type="date"
							name="txfechahasta" class="form-control"
							value="<?php echo (!empty($fechasta) ? $fechasta : null);  ?>">
					</div>
					<div class="col-sm-2">
						<label for="">Seccional</label> 
						<select name="cbSeccional" id="cbSeccional" class="form-control" >
							<?php 
							echo "<option ". (empty($secc) ? "selected" : "")  ." value=''>Todos</option>";
							foreach ($_SESSION["login_ok"]["secc"] as $key => $value) {
								echo "<option ". (empty($secc) ? "" : ($secc == $value ? "selected" : "")) . " value='$value'>$value</option>";
							}  ?>							
							<?php ?>
						</select>
						
					</div>

				</div>

			</div>

			<hr />
			<button id="btnProcesar" class="btn btn-info">Procesar</button>
			<a id="btnLimpiar" class="btn btn-info" href="reloj.php">Limpiar</a>

<br>
<br>
			<div id="comp">

<?php

if (! empty($resultadotxt)) :    
    //Helper::dd($resultadotxt, "resultado return");
	//die();
    ?>


				<div class="card" style="" id="cronograma">

					<div class="card-header">
                        
						<div class="float-left">Resultados:</div>
						<div class="float-right">
							<a href="/controllers/reloj.php?accion=EXPORTAR" class="btn btn-info btn-sm">Exportar</a>
						</div>

                    </div>
					<div class="card-body">
						<div>
							<div class="row">
								<div class="col-12">									
									<table class="table table-bordered  table-striped" style="font-size: 14px" >
										<thead class="thead-dark" >
											<tr>
												<th>N°</th>
												<th style="">Nombre</th>
												<th style="">Estado</th>
												<th style="">Fecha</th>
												<th style="">Pin</th>
												<th style="">DNI</th>												
												<th style="">Seccional</th>		
											</tr>
										</thead>
										<tbody>
								
									<?php
									$contador = 0;
	foreach ($resultadotxt as $item) :
		$contador = $contador + 1;
        ?>
			<tr>
				<td><?php echo $contador ?></td>
				<td><?php echo utf8_encode($item["Name"])?></td>
				<td style="text-align: right"><?php echo intval($item["state"])?></td>
				<td><?php echo ($item["time"])?></td>																										
				<td><?php echo ($item["pin"])?></td>																										
				<td><?php echo ($item["identitycard"])?></td>		
				<td><?php echo ($item["device_name"])?></td>																										
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



				
<?php 
    endif;

?>
	
	</div>

<?php
endif;
?>
		</div>
	</form>



 
 
    </div>
  </div>
</div>


</body>
</html>