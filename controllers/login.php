<?php
require_once('../header.inc.php');
$mensaje = array("tipomsg"=>"","msg"=>"");

//$usu =  new Pr();
//$_SESSION['USUARIO'] = serialize($usu);

try {
    if(!empty($_REQUEST["accion"])){
        switch ($_REQUEST["accion"]) {
                                              
            case "CON_CONTRASEÑA":                               
                $usuario =  $_REQUEST["inputCUIT"];
                $password =  $_REQUEST["inputPassword"];
                  
                $svcLogin = ServiceFactory::getService('login');                                       
                $usu = $svcLogin->validarUsuario($usuario,$password,"");
                if (empty($usu)){
                    $mensaje["tipomsg"] = "danger";
                    $mensaje["msg"] = "<strong>Error al ingresar.</strong><hr>". "Error al ingresar al sistema";
                }else if(  $usu->getId() > 0){                    
                    $_SESSION['USUARIO'] = serialize($usu);
                    header('location: /controllers/inicio.php');                                                           
                }else{
                    $mensaje["tipomsg"] = "danger";
                    $mensaje["msg"] = "<strong>Error al ingresar.</strong><hr>". "Error al ingresar al sistema";                    
                }               
                break;             
            
            case "SAPLOGON":                
                $key_str =  Helper::hexToStr( urldecode($_REQUEST["key"]) )  ;                
                $svcLogin = ServiceFactory::getService('login');                
                $usu = $svcLogin->validarUsuario("","", explode(";",  $key_str));                
                
                Helper::printDebugPanel($usu, "usuario", FALSE, FALSE);
                
                if($usu->getId() > 0){                    
                    $_SESSION['USUARIO'] = serialize($usu);
                    header('location: /controllers/inicio.php');                    
                }else{
                    $mensaje["tipomsg"] = "danger";
                    $mensaje["msg"] = "<strong>Error al ingresar.</strong><hr>". "Error al ingresar al sistema";
                }                               
                break;                
        }
        
    }    
    
    include(ROOT_PATH . '/views/login.php');
        
} catch (Exception $e) {
    
}

?>