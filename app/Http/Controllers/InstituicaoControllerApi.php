<?php

namespace App\Http\Controllers;
use App\Models\Instituicao;
use Illuminate\Http\Request;

class instituicaoControllerApi extends Controller
{
    public function cadastrarInstituicao(Request $request)
    {
        $request->validate([
            'logradouro' => 'required|string',
            'num_logradouro' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'cep' => 'required|string',
            'complemento' => 'nullable|string',
            'cnpj' => 'nullable|string',
            'user_id' => 'required|integer',
        ]);


        $instituicao = Instituicao::create([
            'cnpj_instituicao' => $request->cnpj,
            'logradouro_instituicao' => $request->logradouro,
            'num_logradouro_instituicao' => $request->num_logradouro,
            'bairro_instituicao' => $request->bairro,
            'cidade_instituicao' => $request->cidade,
            'estado_instituicao' => $request->estado,
            'cep_instituicao' => $request->cep,
            'complemento' => $request->complemento,
            'complemento_instituicao' => $request->cnpj,
            'id_user' => $request->user_id,
        ]);
    }
}
