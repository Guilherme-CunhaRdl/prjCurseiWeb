<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    use HasFactory;

    protected $table = 'tb_hashtag';

    protected $fillable = [
        'id',
        'nomeHashtag',
        'created_at',
        'updated_at',
    ]; 

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'tb_post_hashtag', 'id_hashtag', 'id_post');
    }

}
