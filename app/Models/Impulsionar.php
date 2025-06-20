<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impulsionar extends Model
{
    use HasFactory;

    protected $table = 'tb_impulsionar';

    protected $fillable = [
        'id_post',
        'data_fim',
        'created_at',
        'updated_at',
    ];




    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }
}
