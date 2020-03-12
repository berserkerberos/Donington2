<?php
require_once('../header.inc.php');
$mensaje = array("tipomsg"=>"","msg"=>"");
try {
    $renderListado = true;
    if(!empty($_REQUEST["accion"])){
        switch ($_REQUEST["accion"]) {                        
            case "OLVIDO_CONTRASEÑA" :
                
            default:
                $renderListado = true;
                break;
        }
        
    }
        
    
    if ($renderListado){
                
        //$usuLogueado =  unserialize($_SESSION['USUARIO']);                               
        //$sapPedidos = ServiceFactory::getService('sappedido');          
        //$pedidosSAP = $sapPedidos->buscarByProveedor($usuLogueado->getIdSAP(),50);        
        include(ROOT_PATH . '/views/misdatos.php');        
    }       
    
} catch (Exception $e) {
    
}

?>