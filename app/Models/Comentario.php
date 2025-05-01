<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'tb_comentario';

    protected $fillable = [
        'id',
        'comentario',
        'status_comentario',
        'id_user',
        'id_post',
        'id_curtei',
        'created_at',
        'updated_at',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
