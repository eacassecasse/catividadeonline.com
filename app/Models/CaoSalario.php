<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaoSalario extends Model
{
    //Table Name
    protected $table = 'cao_salario';

    //Primary Keys
    protected $primaryKey = 'co_usuario';

    //Timestamps for create and datetimes
    protected const CREATED_ON = null;
    protected const UPDATED_ON = 'dt_alteracao';

    public function caousuario() {
        return $this->belongsTo('App\Models\CaoUsuario');
    }

}
