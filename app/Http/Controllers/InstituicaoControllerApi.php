<?php

namespace App\Http\Controllers;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Curtei;
use App\Models\Comentario;
use App\Models\Curtida;
use App\Models\CurtidaCurtei;
use App\Models\ComentarioCurtei;

use Illuminate\Support\Facades\DB;

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

    public function verificarInstituicaoSolicitada($id)
    {
     
        $instituicao = Instituicao::where('id_user', $id)->first();
        if ($instituicao) {
            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Instituição já cadastrada.',
                'code' => 200,
                'data' => $instituicao,
            ]);
        } else {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Instituição não encontrada.',
                'code' => 404,
            ]);
        }
    }
    public function curteisIntituicaoWeb($id){
         try {
            $curteis = Curtei::with(['usuario'])
                ->withCount(['curtidas', 'comentarios'])
                ->where('status_curtei', '1')
                ->where('id_user',$id)
                ->latest()
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'video_url' => asset($item->caminho_curtei),
                        'thumb_url' => asset($item->caminho_curtei_thumb),
                        'legenda' => $item->legenda_curtei,
                        'curtidas_count' => $item->curtidas_count,
                        'comentarios_count' => $item->comentarios_count,
                        'usuario' => [
                            'id' => $item->usuario->id,
                            'nome' => $item->usuario->nome_user,
                            'foto' => $item->usuario->img_user 
                                ? asset('img/user/fotoPerfil/' . $item->usuario->img_user) 
                                : null,
                            'arroba' => $item->usuario->arroba_user
                        ],
                        'created_at' => $item->created_at->format('d/m/Y H:i')
                    ];
                });
    
            return response()->json(['success' => true, 'videos' => $curteis]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao listar curteis', 'error' => $e->getMessage()], 500);
        }
    }
     public function curteisIntituicaoWebPesquisa($id,$pesquisa){
         try {
            $curteis = Curtei::with(['usuario'])
                ->withCount(['curtidas', 'comentarios'])
                ->where('status_curtei', '1')
                ->where('id_user',$id)
                ->where('legenda_curtei','like',"%$pesquisa%")
                ->latest()
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'video_url' => asset($item->caminho_curtei),
                        'thumb_url' => asset($item->caminho_curtei_thumb),
                        'legenda' => $item->legenda_curtei,
                        'curtidas_count' => $item->curtidas_count,
                        'comentarios_count' => $item->comentarios_count,
                        'usuario' => [
                            'id' => $item->usuario->id,
                            'nome' => $item->usuario->nome_user,
                            'foto' => $item->usuario->img_user 
                                ? asset('img/user/fotoPerfil/' . $item->usuario->img_user) 
                                : null,
                            'arroba' => $item->usuario->arroba_user
                        ],
                        'created_at' => $item->created_at->format('d/m/Y H:i')
                    ];
                });
    
            return response()->json(['success' => true, 'videos' => $curteis]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao listar curteis', 'error' => $e->getMessage()], 500);
        }
    }
    public function engajamentos($id,$tipo){
        if($tipo ==1){
            $comentarios = Comentario::with(['usuario'])
                    ->where('id_post', $id)
                    ->select(
                        '*',
                        DB::raw('TIMESTAMPDIFF(SECOND, created_at, NOW()) AS tempo_insercao'),
                        DB::raw('(SELECT COUNT(*) FROM tb_curtida_comentario WHERE tb_curtida_comentario.id_comentario = tb_comentario.id) AS total_curtidas'),
                    )
                   
                    ->get();
                    $resposta = $comentarios;
        }
        else if ($tipo ==2){
              $curtidas = Curtida::with(['user'])
                    ->where('id_post', $id)
                    ->select(
                        '*',
                        DB::raw('TIMESTAMPDIFF(SECOND, created_at, NOW()) AS tempo_insercao'),
                    )
                   
                    ->get();
                    $resposta = $curtidas;
        }
        else if ($tipo ==3){
              $curtidas = CurtidaCurtei::with(['user'])
                    ->where('id_curtei', $id)
                    ->select(
                        '*',
                        DB::raw('TIMESTAMPDIFF(SECOND, created_at, NOW()) AS tempo_insercao'),
                    )
                   
                    ->get();
                    $resposta = $curtidas;
        }
         else if ($tipo ==4){
              $comentarios = ComentarioCurtei::with(['usuario' => function($q) {
                    $q->select('id', 'nome_user', 'arroba_user', 'img_user');
                }])
                ->withCount('curtidas as total_curtidas' )
                ->where('id_curtei', $id)
                ->orderBy('created_at', 'desc')
                ->get();
                
                    $resposta = $comentarios;
        }
        return $resposta;
    }
}

