<?php

namespace App\Http\Controllers;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Models\User;
class instituicaoControllerApi extends Controller
{
    public function cadastrarInstituicao(Request $request)
    {
        $request->validate([
            'nome_representante' => 'required|string',
            'telefone' => 'required|string',
            'documentos_representante' => 'required|string',
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
            'nome_representante' => $request->nome_representante,
            'telefone' => $request->telefone,
            'documentos_representante' => $request->documentos_representante,
            'logradouro_instituicao' => $request->logradouro,
            'num_logradouro_instituicao' => $request->num_logradouro,
            'bairro_instituicao' => $request->bairro,
            'cidade_instituicao' => $request->cidade,
            'estado_instituicao' => $request->estado,
            'cep_instituicao' => $request->cep,
            'complemento' => $request->complemento,
            'complemento_instituicao' => $request->cnpj,
            'id_user' => $request->user_id,
            'verificado_instituicao' => 0,
        ]);


    }

    public function procurarInstituicao($pesquisa)
    {
    $instituicoes = Instituicao::join('tb_user', 'tb_instituicao.id_user', '=', 'tb_user.id')
        ->where('tb_user.nome_user', 'LIKE', '%' . $pesquisa . '%')
        ->orWhere('arroba_user', 'like', '%' . $pesquisa . '%')
        ->where('tb_user.status_user',1)
        ->get();
        
    return response()->json([
        'sucesso' => true,
        'mensagem' => 'Instituições encontradas com sucesso.',
        'code' => 200,
        'data' => $instituicoes,
    ]);
    }
}
