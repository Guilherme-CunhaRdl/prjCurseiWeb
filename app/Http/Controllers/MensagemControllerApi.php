<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mensagem;
use Illuminate\Support\Facades\Log;
use App\Events\MensagemChat;
use App\Events\TelaChat;
use App\Models\Chat;
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
                    'user1.nome_user AS nome_user1', 
                    'user2.nome_user AS nome_user2',
                    'enviador.nome_user AS nome_enviador',
                    'tb_mensagem.id_user_enviador', 
                    'tb_mensagem.conteudo_mensagem', 
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
        public function enviarMensagem(Request $request)
        {
            $request->validate([
                'idChat' => 'required',
                'conteudoMensagem' => 'required|string',
                'idEnviador' => 'required',
            ]);
    
            $mensagem = new Mensagem();
            $mensagem->id_chat = $request->idChat;
            $mensagem->conteudo_mensagem = $request->conteudoMensagem;
            $mensagem->id_user_enviador = $request->idEnviador;
            $mensagem->status_mensagem = 'enviado';
            $mensagem->created_at = now();
            $mensagem->save();
            
            // $mensagem->load('user');

            Broadcast(new MensagemChat($mensagem))->toOthers();
            // Broadcast(new TelaChat($mensagem->id_user_enviador->nome_user, $mensagem->conteudo_mensagem, $mensagem))->toOthers();

            return response()->json([
                'message' => 'Mensagem enviada com sucesso!',
                'mensagem' => $mensagem,
            ], 201);
        }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
