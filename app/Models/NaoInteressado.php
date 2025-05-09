<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class NaoInteressado extends Model
{
    protected $table = 'tb_nao_interessado_post';

protected $fillable = [
    'id',
    'id_user',
    'id_post',
    'created_at',
    'updated_at',
];

}
