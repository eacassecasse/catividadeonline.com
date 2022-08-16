<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaoFatura extends Model
{
    //Table Name
    protected $table = 'cao_fatura';

    //Primary Keys
    protected $primaryKey = 'co_fatura';

    //Timestamps for create and update datetimes
    protected const CREATED_ON = null;
    protected const UPDATED_ON = 'data_emissao';

    public function caosistema() {
        return $this->belongsTo('App\Models\CaoSistema');
    }

    public function caoos() {
        return $this->belongsTo('App\Models\CaoOs');
    }
}
