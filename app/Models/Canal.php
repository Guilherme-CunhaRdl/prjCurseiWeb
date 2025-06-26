<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    use HasFactory;

    protected $table = 'tb_canal';

    protected $fillable = ['id', 'nome_canal', 'descricao_canal',
     'imagem_canal', 'user_criador_canal', 'created_at','id_curtei',
     'updated_at'];
}
