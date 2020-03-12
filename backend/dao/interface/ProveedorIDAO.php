<?php

interface ProveedorIDAO {

	public function buscarProveedorById($idSAP);
	public function buscarProveedorByCuityPass($cuit, $pass);
}

?>
