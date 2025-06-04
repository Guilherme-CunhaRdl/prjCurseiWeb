<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table ='tb_evento';
    protected $fillable = [
        'id',
        'desc_evento',
        'link_evento',
        'data_inicio_evento',
        'data_fim_evento',
        'status_evento',
        'id_post',
        'created_at',
        'updated_at',

    ];

   

}
