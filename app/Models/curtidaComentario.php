<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurtidaComentario extends Model
{
 

    protected $table = 'tb_curtida_comentario';

    protected $fillable = [
        'id_user',
        'id_comentario',
        'created_at',
        'updated_at',
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relacionamento com o comentário
    public function comentario()
    {
        return $this->belongsTo(Comentario::class, 'id_comentario');
    }
}
