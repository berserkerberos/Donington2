<?php

class LoginService {

    private $proveedorDAO;
    function __construct() {        
        $this->proveedorDAO = DAOFactory::getDAO('usuario');
    }

    public function validarUsuario($usuario,$password,$key) {
        //return $this->ejemploDAO->buscarEjemplo($id);
        $usu  = "";        
        if ($usuario == "ADM" && $password == "12345678" ){
            $usu =  new Usuario();
            $usu->setId(1);
            $usu->setNombreCompleto("ADMIN");
            $usu->setMaquina("maquina");
        }else if (!empty($key)){                
            Helper::printDebugPanel($key, "key", FALSE, FALSE);
            $usu =  $this->proveedorDAO->validUsuSAP($key);                    
        }
                       
        return $usu;
    }    
}
?>