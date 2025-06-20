<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destaque extends Model
{
    use HasFactory;

    protected $table = 'tb_destaque';
    protected $primaryKey = 'id'; // Garanta que está correto
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id', // Adicione esta linha
        'id_user',
        'data_destaque',
        'id_story',
        'foto_destaque',
        'status_destaque'
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function story()
    {
        return $this->belongsTo(Story::class, 'id_story');
    }

}