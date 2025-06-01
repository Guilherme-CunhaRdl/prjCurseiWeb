<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repostar extends Model
{
    protected $table = 'tb_repostar';

    protected $fillable = [
        'desc_repostar',
        'id_user',
        'id_post',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }
}
