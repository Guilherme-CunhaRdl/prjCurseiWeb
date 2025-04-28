<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Seguidores extends Model
{
    use HasFactory;

    protected $table = 'tb_seguidores';

    protected $fillable = [
        'id', 
        'id_user_seguidor', 
        'id_user_seguido', 
        'status_seguidores', 
        'created_at', 
        'updated_at'
    ];

    public $timestamps = false;

        public function seguidor()
        {
            return $this->belongsTo(User::class, 'id_user_seguidor');
        }
    
        public function seguindo()
        {
            return $this->belongsTo(User::class, 'id_user_seguido');
        }
 
    public function usuarioSeguidor()
    {
        return $this->belongsTo(User::class, 'id_user_seguidor');
    }


    public function usuarioSeguido()
    {
        return $this->belongsTo(User::class, 'id_user_seguido');
    }
}
