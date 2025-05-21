<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensagemCanal extends Model
{
    use HasFactory;

    public $table = 'tb_membros_canal';

    public $fillable = ['id','conteudo_mensagem_canal', 'id_canal',  'id_user_enviador', 'created_at', 'updated_at'];
}
