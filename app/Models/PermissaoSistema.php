<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissaoSistema extends Model
{
    //Table Name
    protected $table = 'permissao_sistema';

    //Primary Keys
    protected $primaryKey = ['co_usuario', 'co_tipo_usuario', 'co_sistema'];

    //Timestamps for create and datetimes
    protected const CREATED_ON = null;
    protected const UPDATED_ON = 'dt_atualizacao';

    public function caousuario() {
        return $this->belongsTo('App\Models\CaoUsuario');
    }

    public function caosistema() {
        return $this->belongsTo('App\Models\CaoSistema');
    }
}
