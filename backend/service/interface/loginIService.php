<?php


interface LoginIService {

    public function validarUsuario($usuario, $password);
    public function validarCUIT($cuit);
}

?>
