<?php

//include_once(SERVICE_INTERFACE.'SAPPedidoIService.php');

class SAPExportacionesService  {

    private $exportDAO;

    function __construct() {                                            
    }
        
    /*
     * Condiciones de pago
     * 

C019	VISA
C020	MASTERCARD
C021	DINERS

C022	TARJETA NARANJA
C023	ITALCRED
C024	CABAL
C027	CABAL DEBITO

C025	VISA DEBITO
C026	MAESTRO DEBITO


     * 
     */
    
    public function procesar($exp){
        $resultado =  "";
        
        if ($exp->getTipoExportacion() <> ""){        
            $this->exportDAO = DAOFactory::getDAO($exp->getTipoExportacion());
            $resultado = $this->exportDAO->procesar($exp);                      
        }
        
        return $resultado   ;
    }                   
}
?>
