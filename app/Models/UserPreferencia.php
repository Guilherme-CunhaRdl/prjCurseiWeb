<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreferencia extends Model
{
    use HasFactory;

    protected $table = 'tb_user_preferencia';

    public $fillable = ['id', 'id_user ','preferencia', 'created_at', 'updated_at'];

    public function mensagem(){
        return $this->hasMany(Mensagem::class);
    }
}
