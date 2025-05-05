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
        public function selectMensagensApi($idUserRecebidor )
        {

            $query = DB::table('tb_mensagem')
    ->join('tb_user AS enviador', 'tb_mensagem.id_user_enviador', '=', 'enviador.id')
    ->join('tb_chat AS c', 'tb_mensagem.id_chat','=', 'c.id')
    ->select('c.*', 'tb_mensagem.*', 'enviador.*')
    ->where('c.id_user_recebidor', $idUserRecebidor);
    
// Mostra a query antes de executá-la:
$sql = $query->toSql();
$bindings = $query->getBindings();

// Agora executa a query
$chats = $query->get();

return response()->json([
    'sucesso' => true,
    'chats' => $chats,
    'query' => $sql,
    'bindings' => $bindings,
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
