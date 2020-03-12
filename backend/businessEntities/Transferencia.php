<?php
class Transferencia {
    
    private $entrega;
    private $fecha;
    private $cbu_deb;
    private $cbu_cred;
    private $alias_deb;
    private $alias_cred;
    private $importe;
    private $concepto;
    private $motivo;
    private $referencia;
    private $email;
    private $titulares;
    
    
    

    /**
     * Get the value of entrega
     */ 
    public function getEntrega()
    {
        return $this->entrega;
    }

    /**
     * Set the value of entrega
     *
     * @return  self
     */ 
    public function setEntrega($entrega)
    {
        $this->entrega = $entrega;

        return $this;
    }

    /**
     * Get the value of cbu_deb
     */ 
    public function getCbu_deb()
    {
        return $this->cbu_deb;
    }

    /**
     * Set the value of cbu_deb
     *
     * @return  self
     */ 
    public function setCbu_deb($cbu_deb)
    {
        $this->cbu_deb = $cbu_deb;

        return $this;
    }

    /**
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of cbu_cred
     */ 
    public function getCbu_cred()
    {
        return $this->cbu_cred;
    }

    /**
     * Set the value of cbu_cred
     *
     * @return  self
     */ 
    public function setCbu_cred($cbu_cred)
    {
        $this->cbu_cred = $cbu_cred;

        return $this;
    }

    /**
     * Get the value of alias_deb
     */ 
    public function getAlias_deb()
    {
        return $this->alias_deb;
    }

    /**
     * Set the value of alias_deb
     *
     * @return  self
     */ 
    public function setAlias_deb($alias_deb)
    {
        $this->alias_deb = $alias_deb;

        return $this;
    }

    /**
     * Get the value of alias_cred
     */ 
    public function getAlias_cred()
    {
        return $this->alias_cred;
    }

    /**
     * Set the value of alias_cred
     *
     * @return  self
     */ 
    public function setAlias_cred($alias_cred)
    {
        $this->alias_cred = $alias_cred;

        return $this;
    }

    /**
     * Get the value of importe
     */ 
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set the value of importe
     *
     * @return  self
     */ 
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    
    /**
     * Get the value of concepto
     */ 
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set the value of concepto
     *
     * @return  self
     */ 
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get the value of motivo
     */ 
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set the value of motivo
     *
     * @return  self
     */ 
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get the value of referencia
     */ 
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set the value of referencia
     *
     * @return  self
     */ 
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of titulares
     */ 
    public function getTitulares()
    {
        return $this->titulares;
    }

    /**
     * Set the value of titulares
     *
     * @return  self
     */ 
    public function setTitulares($titulares)
    {
        $this->titulares = $titulares;

        return $this;
    }
}