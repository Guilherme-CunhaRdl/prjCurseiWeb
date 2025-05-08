<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Chat;
use App\Models\Mensagem;

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
                'tb_mensagem.id',
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
