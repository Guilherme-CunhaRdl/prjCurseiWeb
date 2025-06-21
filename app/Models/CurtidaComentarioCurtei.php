<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurtidaComentarioCurtei extends Model
{
    use HasFactory;

    protected $table = 'curtida_comentario_curteis';
    protected $fillable = ['id_comentario', 'id_user'];
}
