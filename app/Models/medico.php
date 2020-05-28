<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class medico  extends Model
{       
    private $med_tipo;
    private $med_firmaimg;
    private $med_cuit;
    private $med_apellido;
    private $med_nombre;
    /*
    use SoftDeletes;
    public $table = 'medicos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'med_id';   
    **/


    //TODO: borrar atributo porque los tiene que traer desde el modelo de base de datos
    
    /**
     * Get the value of med_tipo
     */ 
    public function getMed_tipo()
    {
        return $this->med_tipo;
    }

    /**
     * Set the value of med_tipo
     *
     * @return  self
     */ 
    public function setMed_tipo($med_tipo)
    {
        $this->med_tipo = $med_tipo;

        return $this;
    }

    /**
     * Get the value of med_firmaimg
     */ 
    public function getMed_firmaimg()
    {
        return $this->med_firmaimg;
    }

    /**
     * Set the value of med_firmaimg
     *
     * @return  self
     */ 
    public function setMed_firmaimg($med_firmaimg)
    {
        $this->med_firmaimg = $med_firmaimg;

        return $this;
    }

    /**
     * Get the value of med_cuit
     */ 
    public function getMed_cuit()
    {
        return $this->med_cuit;
    }

    /**
     * Set the value of med_cuit
     *
     * @return  self
     */ 
    public function setMed_cuit($med_cuit)
    {
        $this->med_cuit = $med_cuit;

        return $this;
    }

    /**
     * Get the value of med_apellido
     */ 
    public function getMed_apellido()
    {
        return $this->med_apellido;
    }

    /**
     * Set the value of med_apellido
     *
     * @return  self
     */ 
    public function setMed_apellido($med_apellido)
    {
        $this->med_apellido = $med_apellido;

        return $this;
    }

    /**
     * Get the value of med_nombre
     */ 
    public function getMed_nombre()
    {
        return $this->med_nombre;
    }

    /**
     * Set the value of med_nombre
     *
     * @return  self
     */ 
    public function setMed_nombre($med_nombre)
    {
        $this->med_nombre = $med_nombre;

        return $this;
    }
}
