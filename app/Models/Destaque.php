<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destaque extends Model
{
    use HasFactory;

    protected $table = 'tb_destaque';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'titulo_destaque',
        'data_destaque',
        'foto_destaque',
        'status_destaque'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relacionamento muitos-para-muitos corrigido
    public function stories()
    {
        return $this->belongsToMany(
            Story::class, 
            'destaque_story',  // Nome da tabela pivot
            'destaque_id',     // FK na pivot para destaques
            'story_id'         // FK na pivot para stories
        );
    }
}