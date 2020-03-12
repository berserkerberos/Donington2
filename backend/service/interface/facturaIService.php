<?php

interface FacturaIService {
    public function guardarFactura($factura);
    public function listarFacturas($idSAP);
    public function buscarFacturaById($id);
    public function buscarFacFecEmision($facFecDesde, $facFecHasta);
}

?>