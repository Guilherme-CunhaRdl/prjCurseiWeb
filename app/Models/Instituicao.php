<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
    protected $table ='tb_instituicao';

    protected $fillable = [
        'nome_representante',
        'telefone',
        'documentos_representante',
        'cnpj_instituicao',
        'verificado_instituicao',
        'logradouro_instituicao',
        'num_logradouro_instituicao',
        'bairro_instituicao',
        'cidade_instituicao',
        'estado_instituicao',
        'cep_instituicao',
        'complemento_instituicao',
        'descricao_instituicao',
        'id_user',
        'created_at',
        'updated_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'id_user', 'id_user');
    }
}
