<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioCurtei extends Model
{
    use HasFactory;

    protected $table = 'comentario_curteis';
    protected $fillable = ['id_curtei', 'id_user', 'comentario'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function curtidas()
    {
        return $this->hasMany(CurtidaComentarioCurtei::class, 'id_comentario');
    }

    public function curtei()
    {
        return $this->belongsTo(Curtei::class, 'id_curtei');
    }
}
