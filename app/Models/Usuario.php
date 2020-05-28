<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'nombre_completo', 'password', 'avatar', 'usu_verificado', 'tipo', 'direccion', 'localidad', 'mail', 'telefono', 'observacion'];

    public function cliente()
    {
        return $this->belongsTo('Cliente');
    }
    
}
