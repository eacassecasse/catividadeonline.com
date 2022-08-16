<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaoCliente extends Model
{
    //Table Name
    protected $table = 'cao_cliente';

    //Primary Keys
    protected $primaryKey = 'co_cliente';

    //Timestamps for create and update datetimes
    public $timestamps = false;

    public function facturas() {
        return $this->hasMany('App\Models\CaoFactura');
    }

}
