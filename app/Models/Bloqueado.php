<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Bloqueado extends Model
{
    protected $table = 'tb_bloqueado';

protected $fillable = [
    'id',
    'id_user_bloqueado',
    'id_user_bloqueando',
    'created_at',
    'updated_at',
];

}
