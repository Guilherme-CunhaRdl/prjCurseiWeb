<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destaque extends Model
{
    use HasFactory;

    protected $table = 'tb_destaque';
    protected $primaryKey = 'id_destaque';

    protected $fillable = [
        'id_destaque',
        'id_user',
        'data_destaque',
        'id_story',
        'foto_destaque',
        'status_destaque' // Adicione esta linha
    ];
    
    protected $attributes = [
        'status_destaque' => 1
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function story()
    {
        return $this->belongsTo(Story::class, 'id_story');
    }

}
