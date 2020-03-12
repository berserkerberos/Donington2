<?php


interface ProveedorIService {

    public function buscarId($id);
    public function buscarProveedorByCuityPass($cuit, $pass);
}

?>
