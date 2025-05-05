<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;

    public $table = 'tb_mensagem';

    public $fillable = ['id', 'conteudo_mensagem', 'status_mensagem', 'id_user_enviador','id_chat', 'created_at', 'updated_at'];

    public function chat(){
        return $this->belongsTo(Chat::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'id_user_enviador');
    }
}
