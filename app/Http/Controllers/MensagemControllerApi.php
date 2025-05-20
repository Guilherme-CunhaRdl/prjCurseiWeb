<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mensagem;
use Illuminate\Support\Facades\Log;
use App\Events\MensagemChat;
use App\Events\TelaChat;
use App\Models\Chat;
use App\Models\Canal;
use Illuminate\Support\Facades\Broadcast;


class MensagemControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectChatApi($idUserRecebidor)
    {
        $sub = DB::table('tb_mensagem')
            ->select(DB::raw('MAX(id) as ultima_mensagem_id'))
            ->groupBy('id_chat');
    
        $queryBuilder = DB::table('tb_mensagem')
            ->join('tb_user AS enviador', 'tb_mensagem.id_user_enviador', '=', 'enviador.id')
            ->join('tb_chat AS c', 'tb_mensagem.id_chat', '=', 'c.id')
            ->join('tb_user AS user1', 'c.id_user1', '=', 'user1.id')
            ->join('tb_user AS user2', 'c.id_user2', '=', 'user2.id')
            ->joinSub($sub, 'sub', function ($join) {
                $join->on('tb_mensagem.id', '=', 'sub.ultima_mensagem_id');
            })
            ->select(
                'tb_mensagem.id AS id_mensagem',
                'c.id AS id_chat',
                'user1.nome_user AS nome_user1',
                'user2.nome_user AS nome_user2',
                'enviador.nome_user AS nome_enviador',
                'tb_mensagem.status_mensagem AS status_mensagem',
                'tb_mensagem.id_user_enviador AS enviador',
                'tb_mensagem.conteudo_mensagem AS ultima_mensagem',
                'tb_mensagem.img_mensagem AS foto_enviada',
                DB::raw("IF(user1.id = $idUserRecebidor, user2.nome_user, user1.nome_user) AS nome_enviador"),
                DB::raw("IF(user1.id = $idUserRecebidor, user2.img_user, user1.img_user) AS img_enviador"),
                DB::raw("IF(user1.id = $idUserRecebidor, user2.arroba_user, user1.arroba_user) AS arroba_enviador"),
                DB::raw("IF(user1.id = $idUserRecebidor, user2.id, user1.id) AS id_enviador"),
                'tb_mensagem.created_at'
            )
            ->where(function ($query) use ($idUserRecebidor) {
                $query->where('user1.id', $idUserRecebidor)
                ->orWhere('user2.id', $idUserRecebidor);
            })
            ->orderByDesc('tb_mensagem.created_at');


        $sql = $queryBuilder->toSql();
        $bindings = $queryBuilder->getBindings();
        $chats = $queryBuilder->get();

        // foreach ($chats as $c) {
        //     broadcast(new TelaChat($c))->toOthers();
        // }
        return response()->json([
            'sucesso' => true,
            'chats' => $chats,
            'query' => $sql,
            'bindings' => $bindings,
            'message' => 'Mensagens Retornadas com Sucesso',
            'code' => 200,
        ]);
    }

        public function selectMensagensApi($idChat)
        {


            $query = DB::table('tb_mensagem')
            ->join('tb_user AS enviador', 'tb_mensagem.id_user_enviador', '=', 'enviador.id')
            ->join('tb_chat AS c', 'tb_mensagem.id_chat','=', 'c.id')
            ->join('tb_user AS user1','c.id_user1', '=', 'user1.id')
            ->join('tb_user AS user2','c.id_user2', '=', 'user2.id')
            ->select('c.id AS id_chat' , 
                    'tb_mensagem.id AS id_mensagem',
                    'tb_mensagem.img_mensagem AS foto_enviada',
                    'user1.nome_user AS nome_user1', 
                    'user2.nome_user AS nome_user2',
                    'enviador.nome_user AS nome_enviador',
                    'tb_mensagem.id_user_enviador', 
                    'tb_mensagem.conteudo_mensagem', 
                    'tb_mensagem.img_mensagem AS foto_enviada', 
                    'enviador.id AS id_enviador', 
                    'enviador.img_user' , 
                    'enviador.nome_user')
            ->where('c.id', $idChat)
            ->orderBy('tb_mensagem.created_at', 'asc');

    
            $chats = $query->get();

            return response()->json([
                'sucesso' => true,
                'chats' => $chats,
                
                'message' => 'Mensagens Retornadas com Sucesso',
                'code' => 200,
            ]);


        }

        public function selectSeguidoresSugestoes($idUser){


            $seguidores = DB::table('tb_seguidores AS seg')
                ->join('tb_user AS seguidor', 'seg.id_user_seguidor', '=', 'seguidor.id')
                ->join('tb_user AS seguido', 'seg.id_user_seguido', '=', 'seguido.id')
                ->leftJoin('tb_chat AS c', function ($join) use ($idUser) {
                    $join->on(function ($q) use ($idUser) {
                        $q->on('c.id_user1', '=', 'seg.id_user_seguidor')
                          ->where('c.id_user2', '=', $idUser);
                    })->orOn(function ($q) use ($idUser) {
                        $q->on('c.id_user2', '=', 'seg.id_user_seguidor')
                          ->where('c.id_user1', '=', $idUser);
                    });
                })
                ->where('seg.id_user_seguido', $idUser)
                ->select(
                    'seguidor.id AS id_seguidor',
                    'seguidor.nome_user AS nome_seguidor',
                    'seguidor.img_user AS img_seguidor',
                    'seguidor.arroba_user AS arroba_seguidor',
                    'c.id AS id_chat',
                    'seguido.id AS id_seguido',
                    
                )
                ->orderByDesc('seg.created_at')
                ->distinct()
                ->get();
            

            return response()->json([
                'sucesso' => true,
                'seguidores' => $seguidores,
                'message' => 'Mensagens Retornadas com Sucesso',
                'code' => 200,
            ]);

        }

        public function selectSeguidor($idUser, $idSeguidor){


            $seguidor = DB::table('tb_seguidores AS seg')
                ->join('tb_user AS seguidor', 'seg.id_user_seguidor', '=', 'seguidor.id')
                ->join('tb_user AS seguido', 'seg.id_user_seguido', '=', 'seguido.id')
                ->leftJoin('tb_chat AS c', function ($join) use ($idUser) {
                    $join->on(function ($q) use ($idUser) {
                        $q->on('c.id_user1', '=', 'seg.id_user_seguidor')
                          ->where('c.id_user2', '=', $idUser);
                    })->orOn(function ($q) use ($idUser) {
                        $q->on('c.id_user2', '=', 'seg.id_user_seguidor')
                          ->where('c.id_user1', '=', $idUser);
                    });
                })
                ->where('seg.id_user_seguido', $idUser)
                ->where('seguidor.id', $idSeguidor)
                ->select(
                    'seguidor.id AS id_seguidor',
                    'seguidor.nome_user AS nome_seguidor',
                    'seguidor.img_user AS img_seguidor',
                    'seguidor.arroba_user AS arroba_seguidor',
                    'c.id AS id_chat',
                    'seguido.id AS id_seguido',
                    
                )
                ->distinct()
                ->first();
            

            return response()->json([
                'sucesso' => true,
                'seguidor' => $seguidor,
                'message' => 'Mensagens Retornadas com Sucesso',
                'code' => 200,
            ]);

        }


        public function criarChat(Request $request){

            try{

                $chat = Chat::create([
                    'id_user1' => $request->idUser1,
                    'id_user2' => $request->idUser2,
                    'created_at' => now(),
                ]);

                if (!$chat) {
                    throw new \Exception('Falha ao criar usuário');
                }

                return response()->json([
                    'sucesso' => true,
                    'mensagem' => 'Usuário Cadastrado com Sucesso!',
                    'code' => 200,
                    'chat' => $chat,
                    'id_chat' => $chat->id
                ]);
            }catch (\Exception $e) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Ocorreu um erro durante a Criação do chat: ' . $e->getMessage(),
                    'error' => 'unexpected_error'
                ], 500);
            }

        }
        public function enviarMensagem(Request $request, $tipoMensagem){

            
            $request->validate([
                'idChat' => 'required',
                'idEnviador' => 'required',
            ]);

            $nomeImagem = null;

            if ($request->hasFile('imgMensagem') && $request->file('imgMensagem')->isValid()) {
                $extensao = $request->file('imgMensagem')->getClientOriginalExtension();
                $nomeImagem = time() . '_' . uniqid() . '.' . $extensao;
                $request->file('imgMensagem')->move(public_path('img/chat/fotosChat'), $nomeImagem);
            }
    
            $mensagem = new Mensagem();
            $mensagem->id_chat = $request->idChat;
            $mensagem->conteudo_mensagem = $request->conteudoMensagem;
            $mensagem->img_mensagem = $tipoMensagem == 'semImagem' ? '' : $nomeImagem;
            $mensagem->id_user_enviador = $request->idEnviador;
            $mensagem->status_mensagem = false;
            $mensagem->created_at = now();
            $mensagem->save();


            $idEnviador = $request->idEnviador;
            $sub = DB::table('tb_mensagem')
            ->select(DB::raw('MAX(id) as ultima_mensagem_id'))
            ->groupBy('id_chat');
    
        $queryBuilder = DB::table('tb_mensagem')
            ->join('tb_user AS enviador', 'tb_mensagem.id_user_enviador', '=', 'enviador.id')
            ->join('tb_chat AS c', 'tb_mensagem.id_chat', '=', 'c.id')
            ->join('tb_user AS user1', 'c.id_user1', '=', 'user1.id')
            ->join('tb_user AS user2', 'c.id_user2', '=', 'user2.id')
            ->joinSub($sub, 'sub', function ($join) {
                $join->on('tb_mensagem.id', '=', 'sub.ultima_mensagem_id');
            })
            ->select(
                'tb_mensagem.id AS id_mensagem',
                'c.id AS id_chat',
                'user1.nome_user AS nome_user1',
                'user2.nome_user AS nome_user2',
                'tb_mensagem.status_mensagem AS status_mensagem',
                'tb_mensagem.id_user_enviador AS enviador',
                'tb_mensagem.conteudo_mensagem AS ultima_mensagem',
                'tb_mensagem.img_mensagem AS foto_enviada',
                DB::raw("IF(user1.id = $idEnviador, user2.nome_user, user1.nome_user) AS nome_enviador"),
                DB::raw("IF(user1.id = $idEnviador, user2.img_user, user1.img_user) AS img_enviador"),
                DB::raw("IF(user1.id = $idEnviador, user2.arroba_user, user1.arroba_user) AS arroba_enviador"),
                DB::raw("IF(user1.id = $idEnviador, user2.id, user1.id) AS id_enviador"),
                'tb_mensagem.created_at'
            )
            ->where(function ($query) use ($idEnviador) {
                $query->where('user1.id', $idEnviador)
                ->orWhere('user2.id', $idEnviador);
            })
            ->orderByDesc('id_mensagem');

        $chats = $queryBuilder->get();

            Broadcast(new MensagemChat($mensagem))->toOthers();
            Broadcast(new TelaChat($chats));

            return response()->json([
                'message' => 'Mensagem enviada com sucesso!',
                'paia' => 'teste',
                'mensagem' => $mensagem,
            ], 201);
        

        }

    
        public function pesquisarChats( $pesquisaUsuario, $idUserRecebidor){

            
            $sub = DB::table('tb_mensagem')
            ->select(DB::raw('MAX(id) as ultima_mensagem_id'))
            ->groupBy('id_chat');
    
        $queryBuilder = DB::table('tb_mensagem')
            ->join('tb_user AS enviador', 'tb_mensagem.id_user_enviador', '=', 'enviador.id')
            ->join('tb_chat AS c', 'tb_mensagem.id_chat', '=', 'c.id')
            ->join('tb_user AS user1', 'c.id_user1', '=', 'user1.id')
            ->join('tb_user AS user2', 'c.id_user2', '=', 'user2.id')
            ->joinSub($sub, 'sub', function ($join) {
                $join->on('tb_mensagem.id', '=', 'sub.ultima_mensagem_id');
            })
            ->select(
                'tb_mensagem.id AS id_mensagem',
                'c.id AS id_chat',
                'user1.nome_user AS nome_user1',
                'user2.nome_user AS nome_user2',
                'tb_mensagem.status_mensagem AS status_mensagem',
                'tb_mensagem.id_user_enviador AS enviador',
                'tb_mensagem.conteudo_mensagem AS ultima_mensagem',
                DB::raw("IF(user1.id = $idUserRecebidor, user2.nome_user, user1.nome_user) AS nome_enviador"),
                DB::raw("IF(user1.id = $idUserRecebidor, user2.img_user, user1.img_user) AS img_enviador"),
                DB::raw("IF(user1.id = $idUserRecebidor, user2.arroba_user, user1.arroba_user) AS arroba_enviador"),
                DB::raw("IF(user1.id = $idUserRecebidor, user2.id, user1.id) AS id_enviador"),
                'tb_mensagem.created_at'
            )
            ->where(function ($query) use ($idUserRecebidor) {
                $query->where('user1.id', $idUserRecebidor)
                ->orWhere('user2.id', $idUserRecebidor);
            })
            ->where(function( $query) use ($pesquisaUsuario, $idUserRecebidor){
               $query->whereRaw("IF(user1.id = ?, user2.nome_user, user1.nome_user) LIKE ?", [
                $idUserRecebidor, "%{$pesquisaUsuario}%"
               ]);
            
            })
            ->orderByDesc('id_mensagem');

        $chats = $queryBuilder->get();
            return response()->json([
                 'message' => 'chats retornados',
                 'chats' => $chats,
                 'sql' => $queryBuilder->toSql(),
                 'bindings' => $queryBuilder->getBindings(),
            ]);

        }
        public function criarCanal(Request $request){

            $imgCanal = null;

            if ($request->hasFile('imgCanal') && $request->file('imgCanal')->isValid()) {
                $extensao = $request->file('imgCanal')->getClientOriginalExtension();
                $nomeImagem = time() . '_' . uniqid() . '.' . $extensao;
                $request->file('imgCanal')->move(public_path('img/chat/imgCanal'), $nomeImagem);
                
            }

            $canal = Canal::create([
                'nome_canal' => $request->nomeCanal,
                'descricao_canal' => $request->descricaoCanal,
                'imagem_canal' => $nomeImagem,
                'user_criador_canal' => $request->userCriador,
                'created_at' => now()
            ]);

            return response()->json([
                 'message' => 'canal retornado',
                 'canal Criado' => $canal,
                'sucesso' => true
            ]);

        }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
