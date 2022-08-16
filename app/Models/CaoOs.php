<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaoOs extends Model
{
    //Table Name
    protected $table = 'cao_os';

    //Primary Keys
    protected $primaryKey = 'co_os';

    //Timestamps for create and datetimes
    protected const CREATED_ON = null;
    protected const UPDATED_ON = null;

    public function caousuario() {
        return $this->belongsTo('App\Models\CaoUsuario');
    }

    public function caosistema() {
        return $this->belongsTo('App\Models\CaoSistema');
    }
}
