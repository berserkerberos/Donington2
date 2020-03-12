<?php

class DoningtonService {

    private $doningtonDAO;
    function __construct() {        
        $this->doningtonDAO = DAOFactory::getDAO('donington');
    }

    public function procesar($transferencia) {
        //return $this->ejemploDAO->buscarEjemplo($id);
        $usu  = "";        
        $usu =  $this->doningtonDAO->procesar($transferencia);                           
        return $usu;
    }   
    
    public function consultarTransferencia ($entrega){
        $usu  = "";        
        $usu =  $this->doningtonDAO->consultarTransferencia($entrega);                           
        return $usu;        
    }

    public function traerEntregas(){
        $usu  = "";        
        $usu =  $this->doningtonDAO->traerEntregas();                           
        return $usu;        
    }

    
}
?>