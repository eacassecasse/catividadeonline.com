<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaoUsuario extends Model
{
    //Table Name to use on database
    protected $table = 'cao_usuario';

    // Indicates if there is a timestamp associated with creation and update of entity
    public $timestamps = false;

    // Define id name to look for, in case it is ID, it is not necessary to set it
    public $primaryKey = 'co_usuario';

    public function permissoes() {
        return $this->hasMany('App\Models\PermissaoSistema');
    }

    public function sistemas() {
        return $this->hasMany('App\Models\CaoSistema');
    }

    public function salario() {
        return $this->has('App\Models\CaoSalario');
    }

    public function ordensServico() {
        return $this->has('App\Models\CaoOS');
    }

}
