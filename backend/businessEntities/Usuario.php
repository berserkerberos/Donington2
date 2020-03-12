<?php
class Usuario {
    private $nombreCompleto;
    private $clave;
    private $ultimoIngreso;
    private $ip;
    private $maquina;
    private $id;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombreCompleto()
    {
        return $this->nombreCompleto;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @return mixed
     */
    public function getUltimoIngreso()
    {
        return $this->ultimoIngreso;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getMaquina()
    {
        return $this->maquina;
    }

    /**
     * @param mixed $nombreCompleto
     */
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    /**
     * @param mixed $ultimoIngreso
     */
    public function setUltimoIngreso($ultimoIngreso)
    {
        $this->ultimoIngreso = $ultimoIngreso;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @param mixed $maquina
     */
    public function setMaquina($maquina)
    {
        $this->maquina = $maquina;
    }

    
}