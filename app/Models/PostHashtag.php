<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHashtag extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'tb_post_hashtag';

    // Campos que podem ser preenchidos
    protected $fillable = [
        'id',
        'id_hashtag',
        'id_post',
        'created_at',
        'updated_at',
    ];

    // Relacionamento com a hashtag
    public function hashtag()
    {
        return $this->belongsTo(Hashtag::class, 'id_hashtag');
    }

    // Relacionamento com o post
    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }
}
