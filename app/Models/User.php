<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
        
    // ];
    protected $table ='tb_user';
    protected $fillable = [
        'id',
        'nome_user',
        'email_user',
        'senha_user',
        'img_user',
        'arroba_user',
        'banner_user',
        'token_user',
        'status_user',
        'bio_user',
        'dois-fatores_user',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function instituicao()
    {
        return $this->hasOne(Instituicao::class, 'id_user');
    }
    
    public function posts()
    {
        return $this->hasMany(Post::class, 'id_user');
    }
    
    public function seguidor()
    {
        return $this->hasMany(Seguidores::class, 'id_user_seguido'); 
    }

    public function seguindo()
    {
        return $this->hasMany(Seguidores::class, 'id_user_seguidor'); 
    }
    public function mensagem(){
        return $this->hasOne(Mensagem::class, 'id_user_enviador');
    }
    public function chat(){
        return $this->hasMany(Chat::class);
    }
}
