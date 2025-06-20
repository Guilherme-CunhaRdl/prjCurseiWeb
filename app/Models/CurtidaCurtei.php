<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurtidaCurtei extends Model
{
    use HasFactory;

    protected $table = 'tb_curtida_curtei';

    protected $fillable = [
        'id_user',
        'id_curtei',
    ];


    public function curtidas()
{
    return $this->hasMany(Curtida::class, 'id_curtei');
}

public function curtidasPorUsuario()
{
    return $this->hasMany(Curtida::class, 'id_curtei')->where('id_user', auth()->id());
}

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function curtei()
    {
        return $this->belongsTo(Curtei::class, 'id_curtei');
    }
}
