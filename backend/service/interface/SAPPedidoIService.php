<?php


interface SAPPedidoIService {
    
    public function buscarByProveedor($prov, $limite);
    public function buscarByNroDoc($docu);    
    public function verEstadoPedido($docu);
    public function validaTieneMIGO($docu);
}

?>
