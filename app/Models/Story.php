<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $table = 'tb_storyes';

    protected $fillable = [
        'conteudo_storyes',
        'data_inicio',
        'status_storyes',
        'id_user',
        'legenda',
        'tipo_midia'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'status_storyes' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relacionamento muitos-para-muitos
    public function destaques()
    {
        return $this->belongsToMany(
            Destaque::class,
            'destaque_story',
            'story_id',
            'destaque_id'
        );
    }

    // Acessor para URL completa
    public function getUrlAttribute()
    {
        return url($this->conteudo_storyes);
    }

    public function isImage()
    {
        return $this->tipo_midia === 'image';
    }

    public function isVideo()
    {
        return $this->tipo_midia === 'video';
    }
}