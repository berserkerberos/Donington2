<html>
<head>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script>window.jQuery || document.write('<script src="../js/jquery-3.3.1.min.js"><\/script>')</script>
    

    <!-- Bootstrap core CSS -->    
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script type="text/javascript" src="../js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="../js/general.js" ></script>
 
</head>
<body>

<?php

require_once('../header.inc.php');

echo "Testing SAP odbc....<br>";
// Check if the ODBC extension is loaded
if (! extension_loaded('odbc'))
{
    die('ODBC extension not enabled / loaded');
}

/**
 * 2. HANA ODBC Connection
 */

/*
 * You can download the SAP HANA Client, Developer edition from SAP
 * (which includes the needed driver http://scn.sap.com/docs/DOC-31722)
 *
 * HDBODBC32 -> 32 bit ODBC driver that comes with the SAP HANA Client.
 * HDBODBC -> 64 bit ODBC driver that comes with the SAP HANA Client.
 

 */

$sapAfiliado = ServiceFactory::getService('sapafiliado');

$array =  $sapAfiliado->modificaPadronPorAfiliado();
Helper::utilesPrint($array , "Resultado ", false);
exit();
echo "<hr>";


printArrayPedidos($array);


function printArrayPedidos($array){
    $temp = "";
    if(!empty($array)){
        echo "<div class='table-responsive' >";
        echo "<table class='table table-bordered'>";
        echo "<thead>
                <tr>
                    <th>Detalles</th>
                    <th>Documento</th>
                    <th>Sociedad</th>
                    <th>Fecha Creación</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Org compra</th>
                    <th>Gru compra</th>
                    <th>Monto total</th>    
              </tr></thead>";
        foreach ($array as $r=>$row) {
            //bucle de pedidos cab
            
            $pedidosDet =  $row->getListPedidosDetalle();
            
            echo "<tr>";          
            //imprimir solo si tiene datos
            echo "<td>" . ( count($pedidosDet) > 0 ? "<button class='btn btn-info' >+</button>" : "") . "</td>"	;
            echo "<td>" . $row->getDocumentoComp()	. "</td>"	;
            echo "<td>" . $row->getSociedad()		. "</td>"	;
            echo "<td>" . $row->getFechaCreacion()	. "</td>"	;
            echo "<td>" . $row->getUsuario()		. "</td>"	;
            echo "<td>" . $row->getProveedor()		. "</td>"	;
            echo "<td>" . $row->getOrgCompra()		. "</td>"	;
            echo "<td>" . $row->getGruCompra()		. "</td>"	;
            echo "<td>" . $row->getMontoTotal()		. "</td>"	;
                                    
            echo "</tr>";
            echo "<tr>";
                           
            if (count($pedidosDet) > 0) {
                echo "<table class='table table-bordered' >";
                echo "<thead><tr><th>Posición</th><th>Sociedad</th><th>Almacen</th><th>Detalle</th><th>Cantidad</th><th>Precio</th></tr></thead>";
                echo "<tbody>";
                foreach ($pedidosDet as $c=>$det){    
                    echo "<tr>";
                    echo "<td>" . $det->getPosicion()		. "</td>"	;
                    echo "<td>" . $det->getSociedad()		. "</td>"	;
                    echo "<td>" . $det->getAlmacen()		. "</td>"	;
                    echo "<td>" . $det->getDetalle()		. "</td>"	;
                    echo "<td>" . $det->getCantidad()		. "</td>"	;
                    echo "<td>" . $det->getPrecio()		. "</td>"	;
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
            
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        
        
    }
    
echo $temp;

}
//Helper::utilesPrint($sappedido->verEstadoPedido("4500005362"), "Busca estado de pedido", false);
//Helper::utilesPrint($sappedido->validaTieneMIGO("4500005362"), "valida si tiene MIGO", false);
//Helper::utilesPrint($sappedido->buscarByProveedor("0000020046", 3), "Busca pedidos por proveedor", false);
//Helper::utilesPrint($sapProveedor->buscarById("0000011150"), "Busquerda proveedor por id", false);
//Helper::utilesPrint($sapProveedor->buscarByCUIT("27334575247"), "Busquerda proveedor por CUIT", false);
echo "</br>";
echo "</br>";
echo "</br>";

#cuit 27218655535

exit();







$driver = 'HDBODBC';

// Host
// Note: I am hosting it on the Amazon AWS, so my host looks like this. Put whatever your system administrator gave you
$host = "10.1.54.27:30415";
// Default name of your hana instance
$db_name = "HDB";
// Username
$username = 'USER_QUERY_OLMOS';
// Password
$password = "O4q_olmos02";
/*
echo "odbc:Driver=$driver;ServerNode=$host;Database=$db_name;Uid=$username;Pwd=$password";
echo "</br>";

try{
    $conn = new PDO ("odbc:Driver=$driver;ServerNode=$host;Database=$db_name;Uid=$username;Pwd=$password");
    
    die(json_encode(array('outcome' => true)));
}
catch(PDOException $ex){
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}
exit(); 

**/

// Try to connect

echo "Conexion: Driver=$driver;ServerNode=$host;Database=$db_name;";
$conn = odbc_connect("Driver=$driver;ServerNode=$host;Database=$db_name;", $username, $password, SQL_CUR_USE_ODBC);


if (!$conn)
{
    // Try to get a meaningful error if the connection fails
    echo "Connection failed.\n";
    echo "ODBC error code: " . odbc_error() . ". Message: " . odbc_errormsg();
}
else
{
    //KNTTP
    $sql = "SELECT * FROM SAPABAP1.EKKO WHERE EBELN =4500000150" ;
    $sql = "SELECT *
                FROM SAPABAP1.EKKO 
                    inner join SAPABAP1.EKPO on SAPABAP1.EKKO.ebeln = SAPABAP1.EKPO.ebeln 
    WHERE SAPABAP1.EKKO.EKGRP in ('S02','S06') AND SAPABAP1.EKPO.KNTTP ='K' ";
    
    //SAPABAP1.EKPO.ebeln ='4500012214'";
    $result = odbc_exec($conn, $sql);
    if (!$result){
           echo "Error while sending SQL statement to the database server.\n";
    }else{
        
        while ($row = odbc_fetch_object($result)){
                // Should output one row containing the string 'X'
                echo $row->EBELN . ";" . $row->EKGRP . ";" . $row->MATKL ."<br>";
               //var_dump($row);
               // exit;
        }
    }
    odbc_close($conn);
}


/*
 * 
  #Control de grupo de compras vs grupo de articulos
  $sql = "SELECT SAPABAP1.EKKO.EBELN,SAPABAP1.EKKO.EKGRP,SAPABAP1.EKPO.MATKL 
                FROM SAPABAP1.EKKO 
                    inner join SAPABAP1.EKPO on SAPABAP1.EKKO.ebeln = SAPABAP1.EKPO.ebeln 
                WHERE SAPABAP1.EKKO.EKGRP='S01' AND SAPABAP1.EKPO.MATKL not in ('S00000033','S00000034') ";
    
    $result = odbc_exec($conn, $sql);
    if (!$result){
           echo "Error while sending SQL statement to the database server.\n";
    }else{
        while ($row = odbc_fetch_object($result)){
                // Should output one row containing the string 'X'
                echo $row->EBELN . ";" . $row->EKGRP . ";" . $row->MATKL ."<br>";
            }
    }
 
 
 * 
 * */


?>

	
</body>
</html>
