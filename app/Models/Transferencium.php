<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transferencium extends Model
{
    //use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transferencias';

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
    protected $fillable = ['entrega', 'fecha', 'cbu_debito', 'cbu_credito', 'alias_cbu_debito', 'alias_cbu_credito', 'importe', 'concepto', 'motivo', 'referencia', 'email', 'titulares'];

    public function cliente()
    {
        return $this->belongsTo('Cliente');
    }
    
}
