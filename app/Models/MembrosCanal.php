<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembrosCanal extends Model
{
    use HasFactory;
    public $table = 'tb_membros_canal';

    public $fillable = ['id','id_canal', 'id_user', 'created_at', 'updated_at'];
}
