<?php
require_once ('../header.inc.php');

if (empty($_SESSION['USUARIO'])) {
    header('location: /controllers/login.php');
}

$mensaje = array(
    "tipomsg" => "",
    "msg" => ""
);
$renderListado = false;
//Helper::utilesPrint($_REQUEST, "request entero", true);

function darVista($nombreVista,$codigoPago){
    
    $vista = "";
    $nombreArchivo =  "";
    switch ($nombreVista) {
        
        case "pagofacil":
            $vista = (ROOT_PATH . '/views/pagos/pagofacil.php');
            $nombreArchivo =   $codigoPago. "_" . date("dmY") .  ".ONL";
            break;
        case "rapipago":
            $vista = (ROOT_PATH . '/views/pagos/rapipago.php');
            break;
        case "pagomiscuentas":
            $vista = (ROOT_PATH . '/views/pagos/pagomiscuentas.php');
            $nombreArchivo =  "FAC" . $codigoPago . date("dmy") ;
            break;                
        case "tarjeta_naranja":
            $vista = (ROOT_PATH . '/views/debitos/tarjeta_naranja.php');
            $nombreArchivo =  "daf-" . $codigoPago . ".txt";
            break;
        case "cabal":
            $vista = (ROOT_PATH . '/views/debitos/cabal.php');
            $nombreArchivo =  "COM_002" . $codigoPago . "_". date("his") ;
            break;
        case "italcred":
            $vista = (ROOT_PATH . '/views/debitos/italcred.php');
            $nombreArchivo =  "BASA" . date("my") . ".txt" ;
            break;     
        case "hsbc_gsga":
            $vista = (ROOT_PATH . '/views/debitos/HSBC_CSGA.php');
            $nombreArchivo =  "BASA" . date("my") . ".txt" ;
            break;                   
    }          
    return  ["vista" => $vista, "nombreArchivo" => $nombreArchivo];         
}

try {
    if (! empty($_REQUEST["accion"])) {
        switch ($_REQUEST["accion"]) {
                                     
            case "PROCESAR":                               
                $renderListado = false;
                $tmpResultado = true;
                
                $svcexp = ServiceFactory::getService('sapexportaciones');                                   
                $exp =  new SAPExportaciones();
                                
                //TODO: cambiar flujo para devolver el error con el include de la vista
                $msgError = "";
                
                if (empty($_REQUEST["txFechaDesde"])){
                    //throw new Exception("Complete la fecha desde", 1);
                    $msgError .= "Complete la fecha desde! . ";
                }else{
                    $exp->setFechaDesde($_REQUEST["txFechaDesde"]);
                }
                
                if (empty($_REQUEST["txFechaHasta"])){
                    //throw new Exception("Complete la fecha Hasta", 1);
                    $msgError .= "Complete la fecha hasta! . ";
                }else{
                    $exp->setFechaHasta($_REQUEST["txFechaHasta"]);
                }
                                    
                
                if (empty($_REQUEST["txFechaVencimiento"])){
                    //throw new Exception("Complete la fecha del Vencimiento", 1);
                    $msgError .= "Complete la fecha de vencimiento! . ";
                }else{
                    $exp->setFechaVencimiento($_REQUEST["txFechaVencimiento"]);
                }
                
                if (!empty($_REQUEST["txFechaArchivo"])){
                    $exp->setFechaArchivo($_REQUEST["txFechaArchivo"]);
                }
                
                if (empty($_REQUEST["txCod"])){
                    //throw new Exception("Complete la código", 1);
                    $msgError .= "Complete el código! . ";
                }else{
                    $exp->setCodigoDePago($_REQUEST["txCod"]);
                }
                    
                $vistas  = darVista($_REQUEST["tipo_export"],$_REQUEST["txCod"]);
                
                if( $msgError != ""){                   
                    $mensaje["msg"] = $msgError ;
                    $mensaje["tipomsg"] = "danger" ;
                                    
                    if($vistas["vista"] != ""){
                        include($vistas["vista"]);
                    }                                       
                    die;
                }
                
                $nombreArchivo =  $vistas["nombreArchivo"];
                $exp->setTipoExportacion($_REQUEST["tipo_export"]) ;
                
                $resultado =  $svcexp->procesar($exp);
                if (!empty($resultado)){                    
                    /*
                     * Limpia el output y tira los resultados en un archivo de texto
                     */
                    $nombreArchivo = (empty($nombreArchivo) ? "exportacion_sa25.txt": $nombreArchivo);
                    ob_clean();
                    header("Content-type: text/plain");
                    header("Content-Disposition: attachment; filename=" . $nombreArchivo);
                    echo $resultado;                    
                }else{
                    
                    $mensaje["msg"] = "No se encontraron datos para los filtros indicados!" ;
                    $mensaje["tipomsg"] = "danger" ;
                    
                    
                    if($vistas["vista"] != ""){
                        include($vistas["vista"]);
                    }
                }
                
                die;
                break;
            case "CONSULTA":
                $renderListado = false;
                $tmpResultado = true;
                                             
                die;
                break;
            default:
                
                $vistas = darVista($_REQUEST["accion"],"");                
                if($vistas["vista"] != ""){
                    include($vistas["vista"]);
                }else{
                    Helper::printMensaje("No se determino la operación a realizar", "danger");
                }
                                                
                break;
        }
        
    }else{
        header('location: /controllers/inicio.php');
    }      
    
} catch (Exception $e) {
    Helper::printMensaje( $e->getMessage(), "Error sin controlar");
}


  
?>