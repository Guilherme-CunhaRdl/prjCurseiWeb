<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Denuncia extends Model
{
    protected $table ='tb_denuncia';
    protected $fillable = [
        'id',
        'motivo_denuncia',
        'descricao_denuncia',
        'id_user_denunciador',
        'id_user_denunciado',
        'id_post_denunciado',
        'id_storyes_denunciado',
        'id_curtei_denunciado',
        'created_at',
        'updated_at	',

    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post_denunciado ');
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'id_user_denunciador');
    }

    public function denunciado()
    {
        return $this->belongsTo(User::class, 'id_user_denunciado');
    }

}
