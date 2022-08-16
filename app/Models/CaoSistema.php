<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaoSistema extends Model
{
    //Table Name
    protected $table = 'cao_sistema';

    //Primary Key
    public $primaryKey = 'co_sistema';

    //Timestamps
    public $timestamps = false;

    public function permissoes() {
        return $this->hasMany('App\Models\PermissaoSistema');
    }
}
