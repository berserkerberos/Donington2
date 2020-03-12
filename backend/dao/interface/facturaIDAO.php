<?php

interface facturaIDAO {

    public function guardarFactura(Factura $factura);
    public function listarFacturas($idSAP);
    public function buscarFacturaById($id);
    public function buscarFacFecEmision($facFecDesde, $facFecHasta);
}

?>
