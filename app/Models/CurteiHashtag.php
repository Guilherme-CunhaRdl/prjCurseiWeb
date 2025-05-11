<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurteiHashtag extends Model
{
    use HasFactory;
        protected $table = 'tb_curtei_hashtag';

    // Campos que podem ser preenchidos
    protected $fillable = [
        'id',
        'id_hashtag',
        'id_curtei',
    ];

    // Relacionamento com a hashtag
    public function hashtag()
    {
        return $this->belongsTo(Hashtag::class, 'id_hashtag');
    }

    // Relacionamento com o post
    public function curtei()
    {
        return $this->belongsTo(Curtei::class, 'id_curtei');
    }
}
