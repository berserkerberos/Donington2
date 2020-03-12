<?php
require_once('../header.inc.php');
$mensaje = array("tipomsg"=>"","msg"=>"");

if (empty($_SESSION['USUARIO'])) {
    header('location: /controllers/login.php');
}

try {
    if(!empty($_REQUEST["accion"])){
        switch ($_REQUEST["accion"]) {
            
            
            case "descarga_entre":
                $entrega = (isset($_REQUEST["entrega"]) ? $_REQUEST["entrega"] : 0);
                $svrdonington = ServiceFactory::getService('donington');                                       
                $trans = $svrdonington->consultarTransferencia($entrega) ;
                Helper::escribirCSV($trans,"archivo_nombre.csv",false);
                exit;
                //$entr  = $svrdonington->traerEntregas() ;
                //include(ROOT_PATH . '/views/donington_list.php');
                
            break;
            
            case "listtransferencia":

                $entrega = (isset($_REQUEST["entrega"]) ? $_REQUEST["entrega"] : 0);
                $svrdonington = ServiceFactory::getService('donington');                                       
                $trans = $svrdonington->consultarTransferencia($entrega) ;
                $entr  = $svrdonington->traerEntregas() ;
                include(ROOT_PATH . '/views/donington_list.php');
                exit;                        
            break;
            case "PROCESAR":                               
             
             

               //-- echo "colibri come vieja";
               // exit;
            //var_dump ($_REQUEST);
            //exit;
                $ent = new Transferencia();
                $ent->setEntrega($_REQUEST["txNumEntrega"]); 
                $ent->setFecha($_REQUEST["txFecha"]);                 
                $ent->setCbu_deb($_REQUEST["txCbuDebito"]); 
                $ent->setAlias_cred($_REQUEST["txAliasCbuCred"]); 
                //$ent->setAlias_deb($_REQUEST["TxAliascbu_de"]; 
                $ent->setImporte($_REQUEST["txImporte"]); 
                $ent->setConcepto($_REQUEST["txConcepto"]); 
                $ent->setMotivo($_REQUEST["txMotivo"]); 
                $ent->setReferencia($_REQUEST["txReferencia"]); 
                $ent->setEmail($_REQUEST["txEmail"]); 
               //  $ent->setTitulares($_REQUEST["txTitulares"]); 

                //var_dump ($ent);
                //exit;
                
                
                
                  
                $svrdonington = ServiceFactory::getService('donington');                                       
                $usu = $svrdonington->procesar($ent);
                if (empty($usu)){
                    $mensaje["tipomsg"] = "danger";
                    $mensaje["msg"] = "<strong>Error al ingresar.</strong><hr>". "Error al ingresar al sistema";
                
                }else{
                    $mensaje["tipomsg"] = "success";
                    $mensaje["msg"] = "<strong>se guardo correctamente.</strong><hr>";                    
                } 
                
                //Helper::dd($_REQUEST, "valores en el server");
                //echo "Cargo todo ok!";
                //exit;
                break;             
            
           
        }
        
    }    
    
    include(ROOT_PATH . '/views/donington.php');
        
} catch (Exception $e) {
    
}

?>