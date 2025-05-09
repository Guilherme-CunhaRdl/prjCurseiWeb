<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'tb_chat';

    public $fillable = ['id', 'id_user1','id_user2', 'created_at', 'updated_at'];

    public function mensagem(){
        return $this->hasMany(Mensagem::class);
    }
}
