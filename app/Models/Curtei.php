<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curtei extends Model
{
    use HasFactory;

    protected $table = 'tb_curtei';

    protected $fillable = [
        'titulo_curtei',
        'descricao_curtei',
        'id_user',
        'id_conteudo_curtei',
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
        return $this->hasMany(Curtida::class, 'id_curtei', 'id');
    }

}
