<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPreferencia;
use App\Models\Seguidores;
use App\Models\Bloqueado;
use Error;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexApi()
    {
        $users = User::all();

        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeApi(Request $request)
    {
        try {
            // Verificação de email
            $emailExistente = User::where('email_user', $request->emailUser)->exists();
            if ($emailExistente) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Este email já está cadastrado',
                    'error' => 'email_existente'
                ], 422);
            }

            // Verificação de usuário
            $usuarioExistente = User::where('arroba_user', $request->arrobaUser)->exists();
            if ($usuarioExistente) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Este nome de usuário já está em uso',
                    'error' => 'usuario_existente'
                ], 422);
            }

            // Processamento de imagens
            $nomeImagem = null;
            $nomeBanner = null;

            if ($request->hasFile('imgUser') && $request->file('imgUser')->isValid()) {
                $extensao = $request->file('imgUser')->getClientOriginalExtension();
                $nomeImagem = time() . '_' . uniqid() . '.' . $extensao;
                $request->file('imgUser')->move(public_path('img/user/fotoPerfil'), $nomeImagem);
            }

            if ($request->hasFile('bannerUser') && $request->file('bannerUser')->isValid()) {
                $extensaoBanner = $request->file('bannerUser')->getClientOriginalExtension();
                $nomeBanner = time() . '_' . uniqid() . '.' . $extensaoBanner;
                $request->file('bannerUser')->move(public_path('img/user/bannerPerfil'), $nomeBanner);
            }

            // Criação do usuário
            $user = User::create([
                'nome_user' => $request->nomeUser,
                'email_user' => $request->emailUser,
                'senha_user' => bcrypt($request->senhaUser),
                'img_user' => $nomeImagem,
                'banner_user' => $nomeBanner,
                'status_user' => 1,
                'bio_user' => $request->bioUser,
                'arroba_user' => $request->arrobaUser,
                'created_at' => now(),
            ]);

            if (!$user) {
                throw new \Exception('Falha ao criar usuário');
            }

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Usuário Cadastrado com Sucesso!',
                'code' => 200,
                'User' => $user,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1062) {
                if (str_contains($e->getMessage(), 'email_user')) {
                    return response()->json([
                        'sucesso' => false,
                        'mensagem' => 'Este email já está cadastrado (erro de banco)',
                        'error' => 'email_existente'
                    ], 422);
                } elseif (str_contains($e->getMessage(), 'arroba_user')) {
                    return response()->json([
                        'sucesso' => false,
                        'mensagem' => 'Este nome de usuário já está em uso (erro de banco)',
                        'error' => 'usuario_existente'
                    ], 422);
                }
            }

            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Ocorreu um erro inesperado. Tente novamente mais tarde.',
                'error' => 'database_error'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Ocorreu um erro durante o cadastro: ' . $e->getMessage(),
                'error' => 'unexpected_error'
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showApi($idPerfil,$idUser)
    {
        $user = User::withCount(['seguidor', 'seguindo', 'posts'])
            ->where('id', $idPerfil)
            ->selectRaw('IF(exists(select 1 from tb_instituicao where id_user = tb_user.id and verificado_instituicao = 1), 1, 0) as instituicao')
            ->selectRaw('IF(exists(select 1 from tb_bloqueado where id_user_bloqueado = tb_user.id and id_user_bloqueando = '.$idUser.'), 1, 0) as bloqueando')
            ->selectRaw('IF(exists(select 1 from tb_bloqueado where id_user_bloqueando = tb_user.id and id_user_bloqueado = '.$idUser.'), 1, 0) as bloqueado')

            ->first();


        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Usuario Encontrado com Sucesso!',
            'code' => 200,
            'User' => $user
        ]);
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
    public function updateApi(Request $request, $id)
    {
        $verificarUser = User::all()->where('id', $id);
        $nomeImagem = null;
        $nomeBanner = null;

        foreach ($verificarUser as $item) {

            if ($request->hasFile('imgUser') && $request->file('imgUser')->isValid()) {
                if ($item->img_user && Storage::exists($item->img_user)) {
                    Storage::delete($item->img_user);
                }

                $extensao = $request->imgUser->extension();
                $nomeImagem = md5($request->imgUser->getClientOriginalName() . strtotime('now') . "." . $extensao);
                $request->imgUser->move(public_path('img/img-instituicao/img-perfil'), $nomeImagem);
            }

            if ($request->hasFile('bannerUser') && $request->file('bannerUser')->isValid()) {
                if ($item->img_banner && Storage::exists($item->banner_user)) {
                    Storage::delete($item->banner_user);
                }

                $extensaoBanner = $request->bannerUser->extension();
                $nomeBanner = md5($request->bannerUser->getClientOriginalName() . strtotime('now') . "." . $extensaoBanner);
                $request->bannerUser->move(public_path('img/img-instituicao/banners/'), $nomeBanner);
            }

            $dadosUpdate = [
                'nome_user' => $request->has('nomeUser') ? $request->nomeUser : $item->nome_user,
                'bio_user' => $request->has('bioUser') ? $request->bioUser : $item->bio_user,
                'updated_at' => now()
            ];

            // Mantém os valores originais se não vierem no request
            if ($request->has('emailUser')) $dadosUpdate['email_user'] = $request->emailUser;
            if ($request->has('senhaUser')) $dadosUpdate['senha_user'] = Hash::make($request->senhaUser);
            if ($request->has('statusUser')) $dadosUpdate['status_user'] = $request->statusUser;
            if ($request->has('arrobaUser')) $dadosUpdate['arroba_user'] = $request->arrobaUser;
            if ($nomeImagem) $dadosUpdate['img_user'] = $nomeImagem;
            if ($nomeBanner) $dadosUpdate['banner_user'] = $nomeBanner;

            $user = User::where('id', $id)->update($dadosUpdate);

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Usuario Atualizado com Sucesso!',
                'code' => 200,
                'Post' => $user,

                'novaFoto' => $nomeImagem ?: $item->img_user,
                'novoBanner' => $nomeBanner ?: $item->banner_user
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyApi($id)
    {
        $user = User::where('id', $id)->delete();

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Usuario Excluído com Sucesso!',
            'code' => 200,
        ]);
    }
    public function selectUserLogin(Request $request)
    {
        try {

            $user = DB::table('tb_instituicao')
                ->join('tb_user', 'tb_instituicao.id_user', '=', 'tb_user.id')
                ->select(['tb_instituicao.id AS id_instituicao', 'tb_user.*'])
                ->where('tb_user.email_user', $request->emailDigitado)
                // ->where('tb_user.senha_user', $request->senhaDigitada)
                ->first();

            if(!$user){
                $user = User::where('email_user', $request->emailDigitado)                
                // ->where('senha_user', $request->senhaDigitada)
                ->first();
            }

            $converterNumero = strval($user->id);

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Fim do Processo',
                'code' => 200,
                'usuario' => $user,
                'id_instituicao' => $user->id_instituicao ? $converterNumero : '0' 
            ]);
        } catch (Exception $e) {

            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Fim do Processo',
                'code' => 200,
                'error' => $e
            ]);
        }
    }

    public function verificarEmailExistente(Request $request)
    {
        $email = $request->query('email');
        $existe = User::where('email_user', $email)->exists();

        return response()->json([
            'existe' => $existe
        ]);
    }

    public function verificarUsuarioExistente(Request $request)
    {
        $usuario = $request->query('usuario');
        $existe = User::where('arroba_user', $usuario)->exists();

        return response()->json([
            'existe' => $existe
        ]);
    }
    public function InformacoesUser($id)
    {
        $usuario = User::where('id', $id)->get();

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Usuario encontrado com sucesso!',
            'code' => 200,
            'Post' => $usuario,
        ]);
    }
    public function verificarPreferencia($id)
    {
        $verificar = UserPreferencia::where('id_user', $id)->exists();
        if ($verificar) {
            $resultado = true;
        } else {
            $resultado = false;
        }

        return response()->json([
            'resultado' => $resultado
        ]);
    }
    public function alterarUser(Request $request, $userId)
    {
        $usuario = User::findOrFail($userId);
        $usuario->fill($request->only([
            'nome_user',
            'arroba_user',
            'email_user'
        ]));
        $usuario->save();
        return response()->json(['message' => 'Atualizado com sucesso']);
    }
    public function atualizarDoisFatores(Request $request, $userId)
    {
        \Log::info('Requisição recebida', [
            'userId' => $userId,
            'dados' => $request->all()
        ]);

        $request->validate([
            'dois_fatores_user' => 'required|boolean'
        ]);

        try {
            $user = User::where('id', $userId)->firstOrFail();

            \Log::info('Antes da atualização', [
                'estado_atual' => $user->dois_fatores_user
            ]);

            $user->update([
                'dois_fatores_user' => $request->dois_fatores_user,
            ]);

            \Log::info('Após atualização', [
                'novo_estado' => $user->fresh()->dois_fatores_user
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Configuração atualizada',
                'dois_fatores_user' => $user->dois_fatores_user
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function escolherInteresesses(Request $request)
    {
        try {


            for ($i = 0; $i < count($request->escolhas); $i++) {

                UserPreferencia::create([
                    'id_user' => $request->idUser,
                    'preferencia' => $request->escolhas[$i]
                ]);
            }
            return response()->json([
                'sucesso' => true,
            ]);
        } catch (Error) {
            return response()->json([
                'sucesso' => false,
            ]);
        }
    }
    public function verificarSeSegue($idUser, $idPerfil)
    {
        $segue = Seguidores::where('id_user_seguidor', $idUser)->where('id_user_seguido', $idPerfil)->where('status_seguidores', 1)->exists();
        return response()->json([
            'data' => $segue,
        ]);
    }
    public function BuscarSeguidoresSeguindo($id, $acao)
    {
        if ($acao == 'seguindo') {
            $seguindo = Seguidores::where('id_user_seguidor', $id)
                ->with('usuarioSeguido')
                ->get();

            $retorno = $seguindo->map(function ($item) {
                return $item->usuarioSeguido;
            });
        } elseif ($acao == 'seguidores') {
            $seguindo = Seguidores::where('id_user_seguido', $id)
                ->with('usuarioSeguidor')
                ->get();

            $retorno = $seguindo->map(function ($item) {
                return $item->usuarioSeguidor;
            });
        }

        return $retorno;
    }
    public function deseguirOuTirarSeguidor($idUser, $idPerfil, $acao)
    {
        switch ($acao) {
            case 'desseguir':
                try {
                    Seguidores::where('id_user_seguido', $idPerfil)->where('id_user_seguidor', $idUser)->delete();
                    return response()->json([
                        'sucesso' => true,
                    ]);
                } catch (Error) {
                    return response()->json([
                        'sucesso' => false,
                    ]);
                }
                break;
            case 'removerSeguidor':
                try {
                    Seguidores::where('id_user_seguido', $idUser)->where('id_user_seguidor', $idPerfil)->delete();
                    return response()->json([
                        'sucesso' => true,
                    ]);
                } catch (Error) {
                    return response()->json([
                        'sucesso' => false,
                    ]);
                }
                break;
            case 'pesquisarSeguidores':
                try {

                    $seguidores = Seguidores::where('id_user_seguido', $idPerfil)
                        ->whereHas('usuarioSeguidor', function ($query) use ($idUser) {
                            $query->where('arroba_user', 'like', '%' . $idUser . '%')
                                ->orWhere('nome_user', 'like', '%' . $idUser . '%');
                        })
                        ->with('usuarioSeguidor')
                        ->get()
                        ->pluck('usuarioSeguidor');
                    return response()->json([
                        'sucesso' => true,
                        'data' => $seguidores
                    ]);
                } catch (Error) {
                    return response()->json([
                        'sucesso' => false,
                    ]);
                }
            case 'pesquisarSeguindo':
                try {
                    $seguidores = Seguidores::where('id_user_seguidor', $idPerfil)
                        ->whereHas('usuarioSeguido', function ($query) use ($idUser) {
                            $query->where('arroba_user', 'like', '%' . $idUser . '%')
                                ->orWhere('nome_user', 'like', '%' . $idUser . '%');
                        })
                        ->with('usuarioSeguido')
                        ->get()
                        ->pluck('usuarioSeguido');
                    return response()->json([
                        'sucesso' => true,
                        'data' => $seguidores
                    ]);
                } catch (Error) {
                    return response()->json([
                        'sucesso' => false,
                    ]);
                }
                break;
        }
    }

    public function updatePerfilApi(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Campos básicos (sempre presentes)
            $dadosAtualizados = [
                'nome_user' => $request->nomeUser,
                'bio_user' => $request->bioUser
            ];

            // 1. Verifica e processa a FOTO DE PERFIL (exatamente como seu amigo faz)
            if ($request->hasFile('imgUser')) { // ← AQUI É ONDE VOCÊ USA
                // Remove foto antiga se existir
                if ($user->img_user && file_exists(public_path('img/user/fotoPerfil/' . $user->img_user))) {
                    unlink(public_path('img/user/fotoPerfil/' . $user->img_user));
                }

                $file = $request->file('imgUser'); // Pega o arquivo
                $extensao = $file->getClientOriginalExtension();
                $nomeImagem = 'profile_' . time() . '.' . $extensao;
                $file->move(public_path('img/user/fotoPerfil'), $nomeImagem); // Salva
                $dadosAtualizados['img_user'] = $nomeImagem; // Atualiza no banco
            }

            // 2. Verifica e processa o BANNER (mesma lógica)
            if ($request->hasFile('bannerUser')) { // ← AQUI É ONDE VOCÊ USA
                if ($user->banner_user && file_exists(public_path('img/user/bannerPerfil/' . $user->banner_user))) {
                    unlink(public_path('img/user/bannerPerfil/' . $user->banner_user));
                }

                $file = $request->file('bannerUser');
                $extensao = $file->getClientOriginalExtension();
                $nomeBanner = 'banner_' . time() . '.' . $extensao;
                $file->move(public_path('img/user/bannerPerfil'), $nomeBanner);
                $dadosAtualizados['banner_user'] = $nomeBanner;
            }

            // Atualiza o usuário
            $user->update($dadosAtualizados);

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Perfil atualizado!',
                'foto' => $dadosAtualizados['img_user'] ?? $user->img_user,
                'banner' => $dadosAtualizados['banner_user'] ?? $user->banner_user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Erro: ' . $e->getMessage()
            ], 500);
        }
    }
    public function notificacao($id, $acao)
    {
        $notificacoes = DB::table(DB::raw("(
    -- CURTIDAS
  SELECT 
      CONCAT('curtida_', tb_curtida.id) AS id,
    tb_curtida.created_at,
    'curtida' AS tipo,
    tb_user.nome_user AS usuario,
    tb_user.arroba_user AS arroba,
    tb_user.img_user AS img_user,
    tb_post.titulo_post AS referencia,
    TIMESTAMPDIFF(SECOND, tb_curtida.created_at, NOW()) AS tempo_inserido,
    NULL AS mensagem
    FROM tb_curtida
    JOIN tb_post ON tb_curtida.id_post = tb_post.id
    JOIN tb_user ON tb_curtida.id_user = tb_user.id
    
    WHERE tb_post.id_user = $id

    UNION ALL

    -- COMENTÁRIOS
   SELECT 
    CONCAT('comentario_', tb_comentario.id) AS id,
    tb_comentario.created_at,
    'comentario' AS tipo,
    tb_user.nome_user AS usuario,
    tb_user.arroba_user AS arroba,
    tb_user.img_user AS img_user,
    tb_post.titulo_post AS referencia,
    TIMESTAMPDIFF(SECOND,  tb_comentario.created_at, NOW()) AS tempo_inserido,
    tb_comentario.comentario AS mensagem
    FROM tb_comentario
    JOIN tb_post ON tb_comentario.id_post = tb_post.id
    JOIN tb_user ON tb_comentario.id_user = tb_user.id
    WHERE tb_post.id_user = $id

    UNION ALL

    -- NOVOS SEGUIDORES
   SELECT 
       CONCAT('seguido_', tb_seguidores.id) AS id,

    tb_seguidores.created_at,
    'seguido' AS tipo,
    tb_user.nome_user AS usuario,
    tb_user.arroba_user AS arroba,
    tb_user.img_user AS img_user,
    NULL AS referencia,
    TIMESTAMPDIFF(SECOND, tb_seguidores.created_at, NOW()) AS tempo_inserido,
    NULL AS mensagem
    FROM tb_seguidores
    JOIN tb_user ON tb_seguidores.id_user_seguidor = tb_user.id
    WHERE tb_seguidores.id_user_seguido = $id
) as notificacoes"))
            ->orderBy('created_at', 'desc');


        if ($acao == 'count') {
            $notificacoesAgrupadas = $notificacoes->count();
        } else {
            $notificacoes = $notificacoes->get();
            $agora = now();
            $notificacoesAgrupadas = [
                'ultimos_7_dias' => [],
                'ultimos_30_dias' => [],
                'notificacoes_antigas' => [],
            ];

            foreach ($notificacoes as $notificacao) {
                $dataNotificacao = \Carbon\Carbon::parse($notificacao->created_at);

                if ($dataNotificacao->gt($agora->copy()->subDays(7))) {
                    $notificacoesAgrupadas['ultimos_7_dias'][] = $notificacao;
                } elseif ($dataNotificacao->gt($agora->copy()->subDays(30))) {
                    $notificacoesAgrupadas['ultimos_30_dias'][] = $notificacao;
                } else {
                    $notificacoesAgrupadas['notificacoes_antigas'][] = $notificacao;
                }
            }
        }

        return $notificacoesAgrupadas;
    }
    public function sugerirUsuario($idUser,$limite)
    {
      


   // Primeiro, obtemos as preferências do usuário
    $userPreferences = DB::table('tb_user_preferencia')
        ->where('id_user', $idUser)
        ->pluck('preferencia')
        ->toArray();

    // Se não houver preferências, usar array vazio para evitar erro no SQL
    $preferencesList = !empty($userPreferences) ? $userPreferences : ['Indefinido'];

    $recommendedUsers = DB::table('tb_user as u')
        ->select(
            'u.id',
            'u.nome_user',
            'u.arroba_user',
            'u.img_user',
            DB::raw('
                (SELECT COUNT(*) FROM tb_user_preferencia up 
                 WHERE up.id_user = u.id AND up.preferencia IN ("'.implode('","', $preferencesList).'")) * 5 AS interest_score'),
            DB::raw('
                (SELECT COUNT(*) FROM tb_seguidores s1 
                 WHERE s1.id_user_seguidor = u.id 
                 AND s1.id_user_seguido IN (SELECT id_user_seguido FROM tb_seguidores WHERE id_user_seguidor = '.$idUser.')) * 4 AS following_score'),
            DB::raw('
                (SELECT COUNT(*) FROM tb_seguidores s2 
                 WHERE s2.id_user_seguido = u.id 
                 AND s2.id_user_seguidor IN (SELECT id_user_seguido FROM tb_seguidores WHERE id_user_seguidor = '.$idUser.')) * 4 AS follower_score'),
            DB::raw('
                ((SELECT COUNT(*) FROM tb_comentario c WHERE c.id_user = u.id AND c.id_post IN 
                    (SELECT id FROM tb_post WHERE id_user = '.$idUser.')) +
                 (SELECT COUNT(*) FROM tb_post p WHERE p.repost_id IN 
                    (SELECT id FROM tb_post WHERE id_user = '.$idUser.') AND p.id_user = u.id)) * 3 AS interaction_score'),
            DB::raw('
                (SELECT COUNT(DISTINCT ph1.id_hashtag) FROM tb_post_hashtag ph1 
                 JOIN tb_post p1 ON ph1.id_post = p1.id 
                 WHERE p1.id_user = u.id 
                 AND ph1.id_hashtag IN 
                    (SELECT ph2.id_hashtag FROM tb_post_hashtag ph2 
                     JOIN tb_post p2 ON ph2.id_post = p2.id 
                     WHERE p2.id_user = '.$idUser.')) * 2 AS hashtag_score'),
            DB::raw('
                (SELECT COUNT(*) FROM tb_comentario c 
                 WHERE c.id_user = '.$idUser.' 
                 AND c.id_user = u.id) * 2 AS comment_like_score'),
            DB::raw('
                (SELECT COUNT(*) FROM tb_user_preferencia up 
                 WHERE up.id_user = u.id AND up.preferencia IN ("'.implode('","', $preferencesList).'")) * 5 +
                (SELECT COUNT(*) FROM tb_seguidores s1 
                 WHERE s1.id_user_seguidor = u.id 
                 AND s1.id_user_seguido IN (SELECT id_user_seguido FROM tb_seguidores WHERE id_user_seguidor = '.$idUser.')) * 4 +
                (SELECT COUNT(*) FROM tb_seguidores s2 
                 WHERE s2.id_user_seguido = u.id 
                 AND s2.id_user_seguidor IN (SELECT id_user_seguido FROM tb_seguidores WHERE id_user_seguidor = '.$idUser.')) * 4 +
                ((SELECT COUNT(*) FROM tb_comentario c WHERE c.id_user = u.id AND c.id_post IN 
                    (SELECT id FROM tb_post WHERE id_user = '.$idUser.')) +
                 (SELECT COUNT(*) FROM tb_post p WHERE p.repost_id IN 
                    (SELECT id FROM tb_post WHERE id_user = '.$idUser.') AND p.id_user = u.id)) * 3 +
                (SELECT COUNT(DISTINCT ph1.id_hashtag) FROM tb_post_hashtag ph1 
                 JOIN tb_post p1 ON ph1.id_post = p1.id 
                 WHERE p1.id_user = u.id 
                 AND ph1.id_hashtag IN 
                    (SELECT ph2.id_hashtag FROM tb_post_hashtag ph2 
                     JOIN tb_post p2 ON ph2.id_post = p2.id 
                     WHERE p2.id_user = '.$idUser.')) * 2 +
                (SELECT COUNT(*) FROM tb_comentario c 
                 WHERE c.id_user = '.$idUser.' 
                 AND c.id_user = u.id) * 2 AS total_score')
        )
        ->where('u.id', '!=', $idUser)
        ->whereNotIn('u.id', function($query) use ($idUser) {
            $query->select('id_user_bloqueado')
                  ->from('tb_bloqueado')
                  ->where('id_user_bloqueando', $idUser)
                  ->orWhere('id_user_bloqueado', $idUser);
        })
          ->whereNotIn('u.id', function($query) use ($idUser) {
            $query->select('id_user_bloqueando')
                  ->from('tb_bloqueado')
                  ->where('id_user_bloqueando', $idUser)
                  ->orWhere('id_user_bloqueado', $idUser);
        })
        ->whereNotIn('u.id', function($query) use ($idUser) {
            $query->select('id_user')
                  ->from('tb_nao_interessado_post')
                  ->where('id_user', $idUser);
        })
        
        ->whereNotIn('u.id', function($query) use ($idUser) {
            // Exclui usuários que o $idUser já segue
            $query->select('id_user_seguido')
                  ->from('tb_seguidores')
                  ->where('id_user_seguidor', $idUser)
                  ->where('status_seguidores', 1);
                        })
        ->where('u.status_user', 1)
        ->orderByDesc('total_score')
        ->limit($limite)
        ->get();


    return $recommendedUsers;
}

public function procurarUsuario($pesquisa,$idUser) // Adicione o parâmetro
{
    $usuarios = User::where(function($query) use ($pesquisa) {
        $query->where('nome_user', 'like', '%' . $pesquisa . '%')
              ->orWhere('arroba_user', 'like', '%' . $pesquisa . '%');
    })
    ->whereNotIn('id', function($query) use ($idUser) {
        // Exclui usuários que bloquearam o $idUser
        $query->select('id_user_bloqueando')
              ->from('tb_bloqueado')
              ->where('id_user_bloqueado', $idUser);
    })
    ->whereNot('id',$idUser)
    ->get();
        
    return response()->json([
        'sucesso' => true,
        'mensagem' => 'Usuarios encontrados com sucesso.',
        'code' => 200,
        'data' => $usuarios,
    ]);
}
public function debloquearUser ($idPerfil,$idUser){
        $bloqueado = Bloqueado::where('id_user_bloqueado',$idPerfil)->where('id_user_bloqueando',$idUser)->delete();

       return response()->json([
        'sucesso' => true,
        'mensagem' => 'Usuarios desbloqueado com sucesso.',
        'code' => 200,
        
    ]);
}
}
