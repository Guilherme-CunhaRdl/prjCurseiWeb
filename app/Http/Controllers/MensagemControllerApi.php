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
use App\Models\MensagemCanal;
use App\Models\MembrosCanal;
use Illuminate\Support\Facades\Broadcast;


class MensagemControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectChatApi($idUser, $tipo, $pesquisa)
{
    $idUser = (int) $idUser;
    
  // Subquery para última mensagem privada
$subPrivado = DB::table('tb_mensagem')
    ->select(DB::raw('MAX(id) as ultima_mensagem_id'))
    ->groupBy('id_chat');

$privadasQuery = DB::table('tb_mensagem')
    ->join('tb_chat AS c', 'tb_mensagem.id_chat', '=', 'c.id')
    ->join('tb_user AS user1', 'c.id_user1', '=', 'user1.id')
    ->join('tb_user AS user2', 'c.id_user2', '=', 'user2.id')
    ->joinSub($subPrivado, 'sub', function ($join) {
        $join->on('tb_mensagem.id', '=', 'sub.ultima_mensagem_id');
    })
    ->where(function ($query) use ($idUser) {
        $query->where('user1.id', $idUser)
              ->orWhere('user2.id', $idUser);
    })
    ->whereNotExists(function ($query) use ($idUser) {
        $query->select(DB::raw(1))
              ->from('tb_instituicao AS i')
              ->whereRaw('i.id_user = IF(c.id_user1 = ?, c.id_user2, c.id_user1)', [$idUser]);
    })
   ->selectRaw("
    c.id as id_conversa,
    IF(user1.id = ?, user2.nome_user, user1.nome_user) AS nome,
    IF(user1.id = ?, user2.img_user, user1.img_user) AS img,
    IF(user1.id = ?, user2.arroba_user, user1.arroba_user) AS arroba,
    IF(user1.id = ?, user2.id, user1.id) AS id_remetente,
    tb_mensagem.conteudo_mensagem AS ultima_mensagem,
    tb_mensagem.created_at,
    'privada' AS tipo
", [$idUser, $idUser, $idUser, $idUser]);

$privadasSql = $privadasQuery->toSql();
$privadasBindings = $privadasQuery->getBindings();

$subQueryChatsPrivados = DB::table('tb_chat AS c')
    ->join('tb_user AS user1', 'c.id_user1', '=', 'user1.id')
    ->join('tb_user AS user2', 'c.id_user2', '=', 'user2.id')
    ->where(function ($query) use ($idUser) {
        $query->where('user1.id', $idUser)
              ->orWhere('user2.id', $idUser);
    })
    ->select('c.id');

$instituicoesQuery = DB::table('tb_mensagem')
    ->join('tb_chat AS c', 'tb_mensagem.id_chat', '=', 'c.id')
    ->join('tb_user AS user1', 'c.id_user1', '=', 'user1.id')
    ->join('tb_user AS user2', 'c.id_user2', '=', 'user2.id')
    ->joinSub($subPrivado, 'sub', function ($join) {
        $join->on('tb_mensagem.id', '=', 'sub.ultima_mensagem_id');
    })
    ->join('tb_instituicao AS instituicao', function ($join) use ($idUser) {
        $join->on(DB::raw("IF(user1.id = $idUser, user2.id, user1.id)"), '=', 'instituicao.id_user');
    })
    ->where(function ($query) use ($idUser) {
        $query->where('user1.id', $idUser)
              ->orWhere('user2.id', $idUser);
    })
    ->whereExists(function ($query) use ($idUser) {
        $query->select(DB::raw(1))
              ->from('tb_instituicao AS i')
              ->whereRaw('i.id_user = IF(c.id_user1 = ?, c.id_user2, c.id_user1)', [$idUser]);
    })
   ->selectRaw("
    c.id as id_conversa,
    IF(user1.id = ?, user2.nome_user, user1.nome_user) AS nome,
    IF(user1.id = ?, user2.img_user, user1.img_user) AS img,
    IF(user1.id = ?, user2.arroba_user, user1.arroba_user) AS arroba,
    IF(user1.id = ?, user2.id, user1.id) AS id_remetente,
    tb_mensagem.conteudo_mensagem AS ultima_mensagem,
    tb_mensagem.created_at,
    'instituicao' AS tipo
", [$idUser, $idUser, $idUser, $idUser]);
    
$instituicoesSql = $instituicoesQuery->toSql();
$instituicoesBindings = $instituicoesQuery->getBindings();

// Consulta canais
$subCanais = DB::table('tb_mensagem_canal AS mensagemC')
    ->select(DB::raw('MAX(mensagemC.id) as ultima_mensagem_id'))
    ->groupBy('mensagemC.id_canal');

$canaisQuery = DB::table('tb_canal AS canal')
    ->leftJoin('tb_membros_canal AS membrosC', 'canal.id', '=', 'membrosC.id_canal')
    ->join('tb_user AS user', 'canal.user_criador_canal', '=', 'user.id')
    ->join('tb_mensagem_canal AS mensagemC', 'mensagemC.id_canal', '=', 'canal.id')
    ->joinSub($subCanais, 'sub', function ($join) {
        $join->on('mensagemC.id', '=', 'sub.ultima_mensagem_id');
    })
    ->where(function ($query) use ($idUser) {
        $query->where('membrosC.id_user', $idUser)
              ->orWhere('canal.user_criador_canal', $idUser);
    })
->selectRaw("
    canal.id as id_conversa,
    canal.nome_canal as nome,
    canal.imagem_canal AS img,
    user.arroba_user as arroba,
    mensagemC.id_user_enviador AS id_remetente,
    mensagemC.conteudo_mensagem_canal AS ultima_mensagem,
    mensagemC.created_at,
    'canal' AS tipo
");

$canaisSql = $canaisQuery->toSql();
$canaisBindings = $canaisQuery->getBindings();

$queryUnion = "
    ($privadasSql)
    UNION ALL
    ($instituicoesSql)
    UNION ALL
    ($canaisSql)
    ORDER BY created_at DESC
";

$allBindings = array_merge($privadasBindings, $instituicoesBindings, $canaisBindings);

$conversas = DB::select($queryUnion, $allBindings);

return response()->json([
    'sucesso' => true,
    'mensagem' => 'Conversas retornadas com sucesso.',
    'conversas' => $conversas,
    'code' => 200,
]);
}


    public function selectMensagensApi($idChat)
    {


        $query = DB::table('tb_mensagem')
            ->join('tb_user AS enviador', 'tb_mensagem.id_user_enviador', '=', 'enviador.id')
            ->join('tb_chat AS c', 'tb_mensagem.id_chat', '=', 'c.id')
            ->join('tb_user AS user1', 'c.id_user1', '=', 'user1.id')
            ->join('tb_user AS user2', 'c.id_user2', '=', 'user2.id')
            ->select(
                'c.id AS id_chat',
                'tb_mensagem.id AS id_mensagem',
                'tb_mensagem.img_mensagem AS foto_enviada',
                'user1.nome_user AS nome_user1',
                'user2.nome_user AS nome_user2',
                'enviador.nome_user AS nome_enviador',
                'tb_mensagem.id_user_enviador',
                'tb_mensagem.conteudo_mensagem',
                'tb_mensagem.img_mensagem AS foto_enviada',
                'enviador.id AS id_enviador',
                'enviador.img_user',
                'enviador.nome_user'
            )
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

    public function selectSeguidoresSugestoes($idUser)
    {


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
    ->leftJoin('tb_mensagem AS m', 'm.id_chat', '=', 'c.id') // join mensagens do chat
    ->where('seg.id_user_seguido', $idUser)
    ->whereNull('m.id') // excluir quem tem mensagem (ou seja, mostrar só chats sem mensagens ou sem chat)
    ->select(
        'seguidor.id AS id_seguidor',
        'seguidor.nome_user AS nome_seguidor',
        'seguidor.img_user AS img_seguidor',
        'seguidor.arroba_user AS arroba_seguidor',
        'c.id AS id_chat',
        'seguido.id AS id_seguido'
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

    public function selectSeguidoresConexoes($idUser)
    {


        $conexoesComChat = DB::table('tb_seguidores as s1')
            ->join('tb_seguidores as s2', function ($join) {
                $join->on('s1.id_user_seguidor', '=', 's2.id_user_seguido')
                    ->on('s1.id_user_seguido', '=', 's2.id_user_seguidor');
            })
            ->join('tb_user as u', 'u.id', '=', 's1.id_user_seguidor')
            ->leftJoin('tb_chat as c', function ($join) use ($idUser) {
                $join->on(function ($query) use ($idUser) {
                    $query->where(function ($q) use ($idUser) {
                        $q->whereColumn('c.id_user1', 's1.id_user_seguidor')
                            ->where('c.id_user2', $idUser);
                    })->orWhere(function ($q) use ($idUser) {
                        $q->whereColumn('c.id_user2', 's1.id_user_seguidor')
                            ->where('c.id_user1', $idUser);
                    });
                });
            })
            ->where('s1.id_user_seguido', $idUser) // quem me segue
            ->where('s2.id_user_seguidor', $idUser) // que eu também sigo
            ->select(
                'u.id as user_id',
                'u.nome_user AS nome_seguidor',
                'u.img_user AS img_seguidor',
                'u.arroba_user AS arroba_seguidor',
                'c.id as id_chat',
                's1.id_user_seguidor AS id_seguidor',
                's2.id_user_seguido AS id_seguido',
                'c.id_user1',
                'c.id_user2'
            )
            ->get();





        return response()->json([
            'sucesso' => true,
            'conexoes' => $conexoesComChat,
            'message' => 'Mensagens Retornadas com Sucesso',
            'code' => 200,
        ]);
    }
    public function selectAddChatSugestoes($idUser)
    {
        // Primeiro, obtemos as preferências do usuário
        $userPreferences = DB::table('tb_user_preferencia')
            ->where('id_user', $idUser)
            ->pluck('preferencia')
            ->toArray();

        // Se não houver preferências, usar array vazio para evitar erro no SQL
        $preferencesList = !empty($userPreferences) ? $userPreferences : ['Indefinido'];

        $recommendedUsers = DB::table('tb_user as u')
            ->leftJoin('tb_seguidores as s1', function ($join) use ($idUser) {
                $join->on('s1.id_user_seguidor', '=', 'u.id')
                    ->where('s1.id_user_seguido', '=', $idUser);
            })
            ->leftJoin('tb_seguidores as s2', function ($join) use ($idUser) {
                $join->on('s2.id_user_seguido', '=', 'u.id')
                    ->where('s2.id_user_seguidor', '=', $idUser);
            })
            ->leftJoin('tb_chat as c', function ($join) use ($idUser) {
                $join->on(function ($query) use ($idUser) {
                    $query->where(function ($q) use ($idUser) {
                        $q->whereColumn('c.id_user1', 'u.id')
                            ->where('c.id_user2', '=', $idUser);
                    })->orWhere(function ($q) use ($idUser) {
                        $q->whereColumn('c.id_user2', 'u.id')
                            ->where('c.id_user1', '=', $idUser);
                    });
                });
            })
            ->select(
                'u.id',
                'u.nome_user AS nome_seguidor',
                'u.arroba_user AS arroba_seguidor',
                'u.img_user AS img_seguidor',
                'c.id as id_chat',
                's1.id_user_seguidor AS id_seguidor',
                's2.id_user_seguido AS id_seguido',
                'c.id_user1',
                'c.id_user2',
                DB::raw('
                (SELECT COUNT(*) FROM tb_user_preferencia up 
                 WHERE up.id_user = u.id AND up.preferencia IN ("' . implode('","', $preferencesList) . '")) * 5 AS interest_score'),
                DB::raw('
                (SELECT COUNT(*) FROM tb_seguidores s1 
                 WHERE s1.id_user_seguidor = u.id 
                 AND s1.id_user_seguido IN (SELECT id_user_seguido FROM tb_seguidores WHERE id_user_seguidor = ' . $idUser . ')) * 4 AS following_score'),
                DB::raw('
                (SELECT COUNT(*) FROM tb_seguidores s2 
                 WHERE s2.id_user_seguido = u.id 
                 AND s2.id_user_seguidor IN (SELECT id_user_seguido FROM tb_seguidores WHERE id_user_seguidor = ' . $idUser . ')) * 4 AS follower_score'),
                DB::raw('
                ((SELECT COUNT(*) FROM tb_comentario c WHERE c.id_user = u.id AND c.id_post IN 
                    (SELECT id FROM tb_post WHERE id_user = ' . $idUser . ')) +
                 (SELECT COUNT(*) FROM tb_post p WHERE p.repost_id IN 
                    (SELECT id FROM tb_post WHERE id_user = ' . $idUser . ') AND p.id_user = u.id)) * 3 AS interaction_score'),
                DB::raw('
                (SELECT COUNT(DISTINCT ph1.id_hashtag) FROM tb_post_hashtag ph1 
                 JOIN tb_post p1 ON ph1.id_post = p1.id 
                 WHERE p1.id_user = u.id 
                 AND ph1.id_hashtag IN 
                    (SELECT ph2.id_hashtag FROM tb_post_hashtag ph2 
                     JOIN tb_post p2 ON ph2.id_post = p2.id 
                     WHERE p2.id_user = ' . $idUser . ')) * 2 AS hashtag_score'),
                DB::raw('
                (SELECT COUNT(*) FROM tb_comentario c 
                 WHERE c.id_user = ' . $idUser . ' 
                 AND c.id_user = u.id) * 2 AS comment_like_score'),
                DB::raw('
                (SELECT COUNT(*) FROM tb_user_preferencia up 
                 WHERE up.id_user = u.id AND up.preferencia IN ("' . implode('","', $preferencesList) . '")) * 5 +
                (SELECT COUNT(*) FROM tb_seguidores s1 
                 WHERE s1.id_user_seguidor = u.id 
                 AND s1.id_user_seguido IN (SELECT id_user_seguido FROM tb_seguidores WHERE id_user_seguidor = ' . $idUser . ')) * 4 +
                (SELECT COUNT(*) FROM tb_seguidores s2 
                 WHERE s2.id_user_seguido = u.id 
                 AND s2.id_user_seguidor IN (SELECT id_user_seguido FROM tb_seguidores WHERE id_user_seguidor = ' . $idUser . ')) * 4 +
                ((SELECT COUNT(*) FROM tb_comentario c WHERE c.id_user = u.id AND c.id_post IN 
                    (SELECT id FROM tb_post WHERE id_user = ' . $idUser . ')) +
                 (SELECT COUNT(*) FROM tb_post p WHERE p.repost_id IN 
                    (SELECT id FROM tb_post WHERE id_user = ' . $idUser . ') AND p.id_user = u.id)) * 3 +
                (SELECT COUNT(DISTINCT ph1.id_hashtag) FROM tb_post_hashtag ph1 
                 JOIN tb_post p1 ON ph1.id_post = p1.id 
                 WHERE p1.id_user = u.id 
                 AND ph1.id_hashtag IN 
                    (SELECT ph2.id_hashtag FROM tb_post_hashtag ph2 
                     JOIN tb_post p2 ON ph2.id_post = p2.id 
                     WHERE p2.id_user = ' . $idUser . ')) * 2 +
                (SELECT COUNT(*) FROM tb_comentario c 
                 WHERE c.id_user = ' . $idUser . ' 
                 AND c.id_user = u.id) * 2 AS total_score')
            )
            ->where('u.id', '!=', $idUser)
            ->whereNotIn('u.id', function ($query) use ($idUser) {
                $query->select('id_user_bloqueado')
                    ->from('tb_bloqueado')
                    ->where('id_user_bloqueando', $idUser)
                    ->orWhere('id_user_bloqueado', $idUser);
            })
            ->whereNotIn('u.id', function ($query) use ($idUser) {
                $query->select('id_user')
                    ->from('tb_nao_interessado_post')
                    ->where('id_user', $idUser);
            })

            ->whereNotIn('u.id', function ($query) use ($idUser) {
                // Exclui usuários que o $idUser já segue
                $query->select('id_user_seguido')
                    ->from('tb_seguidores')
                    ->where('id_user_seguidor', $idUser)
                    ->where('status_seguidores', 1);
            })
            ->whereNotIn('u.id', function ($query) use ($idUser) {
                $query->selectRaw('
        CASE 
            WHEN c.id_user1 = ? THEN c.id_user2 
            ELSE c.id_user1 
        END', [$idUser])
                    ->from('tb_chat as c')
                    ->join('tb_mensagem as m', 'm.id_chat', '=', 'c.id')
                    ->where(function ($q) use ($idUser) {
                        $q->where('c.id_user1', $idUser)
                            ->orWhere('c.id_user2', $idUser);
                    });
            })

            ->where('u.status_user', 1)
            ->groupBy(
                'u.id',
                'u.nome_user',
                'u.arroba_user',
                'u.img_user',
                'c.id',
                's1.id_user_seguidor',
                's2.id_user_seguido',
                'c.id_user1',
                'c.id_user2'
            )
            ->orderByDesc('total_score')
            ->limit(50)
            ->get();


        return response()->json([
            'sucesso' => true,
            'sugestoes' => $recommendedUsers,
            'message' => 'Mensagens Retornadas com Sucesso',
            'code' => 200,
        ]);
    }
    public function selectSeguidor($idUser, $idSeguidor)
    {


        $usuario = DB::table('tb_user AS seguidor')
    ->leftJoin('tb_seguidores AS seg', function ($join) use ($idUser) {
        $join->on('seg.id_user_seguidor', '=', 'seguidor.id')
            ->where('seg.id_user_seguido', '=', $idUser);
    })
    ->leftJoin('tb_user AS seguido', 'seg.id_user_seguido', '=', 'seguido.id')
    ->leftJoin('tb_chat AS c', function ($join) use ($idUser) {
        $join->on(function ($q) use ($idUser) {
            $q->on('c.id_user1', '=', 'seguidor.id')
              ->where('c.id_user2', '=', $idUser);
        })->orOn(function ($q) use ($idUser) {
            $q->on('c.id_user2', '=', 'seguidor.id')
              ->where('c.id_user1', '=', $idUser);
        });
    })
    ->where('seguidor.id', $idSeguidor) 
    ->select(
        'seguidor.id AS id_seguidor',
        'seguidor.nome_user AS nome_seguidor',
        'seguidor.img_user AS img_seguidor',
        'seguidor.arroba_user AS arroba_seguidor',
        'c.id AS id_chat',
        'seguido.id AS id_seguido'
    )
    ->first();



        return response()->json([
            'sucesso' => true,
            'seguidor' => $usuario,
            'message' => 'Seguidores Retornados com Sucesso',
            'code' => 200,
        ]);
    }


    public function criarChat(Request $request)
    {

        try {

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
        } catch (\Exception $e) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Ocorreu um erro durante a Criação do chat: ' . $e->getMessage(),
                'error' => 'unexpected_error'
            ], 500);
        }
    }
    public function enviarMensagem(Request $request, $tipoMensagem)
    {


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
        broadcast(new TelaChat($chats, $request->idChat));

        return response()->json([
            'message' => 'Mensagem enviada com sucesso!',
            'paia' => 'teste',
            'mensagem' => $mensagem,
        ], 201);
    }


    public function pesquisarChats($pesquisaUsuario, $idUserRecebidor)
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
            ->where(function ($query) use ($pesquisaUsuario, $idUserRecebidor) {
                $query->whereRaw("IF(user1.id = ?, user2.nome_user, user1.nome_user) LIKE ?", [
                    $idUserRecebidor,
                    "%{$pesquisaUsuario}%"
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
    public function criarCanal(Request $request)
    {

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
    public function selecionarCanais($idUser)
    {

        $subQ = DB::table('tb_mensagem_canal AS mensagemC')
            ->select(DB::raw('MAX(mensagemC.id) as ultima_mensagem_id'))
            ->groupBy('mensagemC.id_canal');

        $canais = DB::table('tb_canal AS canal')
            ->leftJoin('tb_membros_canal AS membrosC', 'canal.id', '=', 'membrosC.id_canal')
            ->join('tb_user AS user', 'canal.user_criador_canal', '=', 'user.id')
            ->join('tb_mensagem_canal AS mensagemC', 'mensagemC.id_canal', '=', 'canal.id')
            ->joinSub($subQ, 'sub', function ($join) {
                $join->on('mensagemC.id', '=', 'sub.ultima_mensagem_id');
            })
            ->where(function ($query) use ($idUser) {
                $query->where('membrosC.id_user', '=', $idUser)
                    ->orWhere('canal.user_criador_canal', '=', $idUser);
            })
            ->select([
                'canal.id AS id_canal',
                'canal.nome_canal',
                'canal.descricao_canal',
                'canal.imagem_canal AS img_canal',
                'canal.created_at AS data_criacao',
                'user.id AS id_enviador',
                'user.nome_user AS nome_enviador',
                'user.arroba_user AS arroba_enviador',
                'user.img_user AS img_enviador',
                'mensagemC.id AS id_mensagem',
                'mensagemC.conteudo_mensagem_canal AS ultima_mensagem',
                'mensagemC.created_at AS data_envio_mensagem',
            ])
            ->distinct()
            ->get();

        return response()->json([
            'message' => 'canal retornado com sucesso',
            'canais' => $canais,
            'sucesso' => true
        ]);
    }

    public function selectMensagensCanalApi($idEnviador)
    {
        $mensagensCanal = DB::table('tb_canal AS canal')
            ->join('tb_user AS user', 'canal.user_criador_canal', '=', 'user.id')
            ->join('tb_mensagem_canal AS mensagemC', 'mensagemC.id_canal', '=', 'canal.id')
            ->select([
                'canal.id AS id_canal',
                'canal.nome_canal',
                'canal.descricao_canal',
                'canal.imagem_canal AS img_canal',
                'canal.created_at AS data_criacao',
                'user.id AS id_enviador',
                'user.nome_user AS nome_enviador',
                'user.arroba_user AS arroba_enviador',
                'user.img_user AS img_enviador',
                'mensagemC.id AS id_mensagem',
                'mensagemC.conteudo_mensagem_canal AS conteudo_mensagem',
                'mensagemC.created_at AS data_envio_mensagem',
                'mensagemC.img_mensagem_canal AS foto_enviada',

            ])
            ->where('canal.user_criador_canal', '=', $idEnviador)
            ->orderBy('mensagemC.created_at', 'asc')
            ->get();





        return response()->json([
            'sucesso' => true,
            'mensagensCanal' => $mensagensCanal,

            'message' => 'Mensagens Retornadas com Sucesso',
            'code' => 200,
        ]);
    }
}
