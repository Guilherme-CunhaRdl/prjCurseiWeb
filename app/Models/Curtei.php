<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curtei extends Model
{
    use HasFactory;

    protected $table = 'tb_curtei';

    protected $fillable = [
        'caminho_curtei',
        'caminho_curtei_thumb',
        'legenda_curtei',
        'id_user',
        //'id_conteudo_curtei',
        'created_at',
        'updated_at',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function conteudo()
    {
        return $this->belongsTo(ConteudoCurtei::class, 'id_conteudo_curtei');
    }
    public function curtidas()
    {
        return $this->hasMany(CurtidaCurtei::class, 'id_curtei');
    }

    public function comentarios()
{
    return $this->hasMany(ComentarioCurtei::class, 'id_curtei');
}

    public function comentariosCount()
    {
        return $this->hasMany(ComentarioCurtei::class, 'id_curtei')->count();
    }


    public function curtidasPorUsuario()
{
    return $this->hasMany(CurtidaCurtei::class, 'id_curtei')
                ->where('id_user', auth()->id());
}

}
