<?php

class SAPExportaciones 
{
    private $fechaDesde;
    private $fechaHasta;
    private $fechaArchivo;
    private $codigoDePago;
    private $concepto;    
    private $fechaVencimiento;
    
    private $tipoExportacion;
    
    /**
     * @return mixed
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * @param mixed $fechaVencimiento
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;
    }

    /**
     * @return mixed
     */
    public function getTipoExportacion()
    {
        return $this->tipoExportacion;
    }

    /**
     * @param mixed $tipoExportacion
     */
    public function setTipoExportacion($tipoExportacion)
    {
        $this->tipoExportacion = $tipoExportacion;
    }

    /**
     * @return mixed
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * @return mixed
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * @return mixed
     */
    public function getFechaArchivo()
    {
        return $this->fechaArchivo;
    }

    /**
     * @return mixed
     */
    public function getCodigoDePago()
    {
        return $this->codigoDePago;
    }

    /**
     * @return mixed
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * @param mixed $fechaDesde
     */
    public function setFechaDesde($fechaDesde)
    {
        $this->fechaDesde = $fechaDesde;
    }

    /**
     * @param mixed $fechaHasta
     */
    public function setFechaHasta($fechaHasta)
    {
        $this->fechaHasta = $fechaHasta;
    }

    /**
     * @param mixed $fechaArchivo
     */
    public function setFechaArchivo($fechaArchivo)
    {
        $this->fechaArchivo = $fechaArchivo;
    }

    /**
     * @param mixed $codigoDePago
     */
    public function setCodigoDePago($codigoDePago)
    {
        $this->codigoDePago = $codigoDePago;
    }

    /**
     * @param mixed $concepto
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;
    }

    
}
