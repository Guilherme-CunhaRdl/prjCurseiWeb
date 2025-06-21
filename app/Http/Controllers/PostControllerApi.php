<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Curtida;
use App\Models\Comentario;
use App\Models\Denuncia;
use App\Models\Seguidores;
use App\Models\Bloqueado;
use App\Models\NaoInteressado;
use App\Models\Hashtag;
use App\Models\CurtidaComentario;
use App\Models\PostHashtag;
use App\Models\Evento;
use App\Models\Impulsionar;
use Error;
use Illuminate\Support\Facades\File;

use GuzzleHttp\Psr7\Query;
use Illuminate\Support\Facades\DB;



class PostControllerApi extends Controller
{
    public function posts($tipo, $idUser, $quantidade, $pagina, $pesquisa)
    {
        $ignorarPosts = 0;
        for ($i = 0; $i <= $pagina; $i++) {
            $ignorarPosts = $ignorarPosts + $quantidade;
        };
        $ignorarPosts = $ignorarPosts - $quantidade;

        $query = DB::table('tb_post')
            ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
            ->leftJoin('tb_post as repost', 'tb_post.repost_id', '=', 'repost.id')
            ->leftJoin('tb_user as repost_user', 'repost.id_user', '=', 'repost_user.id')
            ->leftJoin('tb_curtida', 'tb_post.id', '=', 'tb_curtida.id_post')
            ->leftJoin('tb_comentario', 'tb_post.id', '=', 'tb_comentario.id_post')
            ->leftJoin('tb_seguidores', 'tb_post.id_user', '=', 'id_user_seguido')
            ->leftJoin('tb_evento', 'tb_post.id', '=', 'tb_evento.id_post')
            ->leftJoin('tb_impulsionar', 'tb_post.id', '=', 'tb_impulsionar.id_post');

        if ($tipo == 1 || $tipo == 7 || $tipo == 8 || $tipo == 3 || $tipo == 9) {

            $preferencias = DB::table('tb_user_preferencia')
                ->where('id_user', $idUser)
                ->pluck('preferencia')
                ->toArray();
            $preferenciasStr = implode(',', array_map(function ($a) {
                return "'$a'";
            }, $preferencias));

            $usuariosNaoInteressados = DB::table('tb_nao_interessado_post')
                ->join('tb_post', 'tb_nao_interessado_post.id_post', '=', 'tb_post.id')
                ->where('tb_nao_interessado_post.id_user', $idUser)
                ->pluck('tb_post.id_user')
                ->toArray();

            $areasNaoInteressadas = DB::table('tb_nao_interessado_post')
                ->join('tb_post', 'tb_nao_interessado_post.id_post', '=', 'tb_post.id')
                ->where('tb_nao_interessado_post.id_user', $idUser)
                ->pluck('tb_post.area_post')
                ->toArray();
            $usuariosStr = !empty($usuariosNaoInteressados)
                ? implode(',', $usuariosNaoInteressados)
                : 'NULL';

            $areasStr = !empty($areasNaoInteressadas)
                ? implode(',', array_map(fn($a) => "'$a'", $areasNaoInteressadas))
                : "'NULL'";
            $subQuery = DB::table('tb_post')
                ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
                ->leftJoin('tb_post as repost', 'tb_post.repost_id', '=', 'repost.id')
                ->leftJoin('tb_user as repost_user', 'repost.id_user', '=', 'repost_user.id')
                ->leftJoin('tb_curtida', 'tb_post.id', '=', 'tb_curtida.id_post')
                ->leftJoin('tb_comentario', 'tb_post.id', '=', 'tb_comentario.id_post')
                ->leftJoin('tb_impulsionar', 'tb_post.id', '=', 'tb_impulsionar.id_post')

                ->leftJoin('tb_seguidores', function ($join) use ($idUser) {
                    $join->on('tb_seguidores.id_user_seguidor', '=', DB::raw($idUser))
                        ->on('tb_seguidores.id_user_seguido', '=', 'tb_post.id_user');
                })
                ->leftJoin('tb_bloqueado as bloqueio1', function ($join) use ($idUser) {
                    $join->on('bloqueio1.id_user_bloqueado', '=', 'tb_post.id_user')
                        ->where('bloqueio1.id_user_bloqueando', '=', DB::raw($idUser));
                })
                ->leftJoin('tb_bloqueado as bloqueio2', function ($join) use ($idUser) {
                    $join->on('bloqueio2.id_user_bloqueando', '=', 'tb_post.id_user')
                        ->where('bloqueio2.id_user_bloqueado', '=', DB::raw($idUser));
                })
                ->leftJoin('tb_nao_interessado_post', function ($join) use ($idUser) {
                    $join->on('tb_nao_interessado_post.id_post', '=', 'tb_post.id')
                        ->where('tb_nao_interessado_post.id_user', '=', DB::raw($idUser));
                })
                ->leftJoin('tb_evento', 'tb_post.id', '=', 'tb_evento.id_post') // Adicionado
                ->whereNull('bloqueio1.id')->whereNull('bloqueio2.id')
                ->where('tb_post.id_user', '!=', $idUser)
                ->where('tb_post.status_post', 1)
                ->where('tb_user.status_user', 1)
                ->where('tb_post.created_at', '<=', now());
            if ($tipo == 3 || $tipo == 9) {
                $subQuery = $subQuery->where(function ($query) use ($pesquisa) {
                    $query->where('tb_user.arroba_user', 'like', "%$pesquisa%")
                        ->orWhere('tb_user.nome_user', 'like', "%$pesquisa%")
                        ->orWhere('tb_post.descricao_post', 'like', "%$pesquisa%");
                });
            }
            $subQuery = $subQuery
                ->groupBy(
                    'tb_post.id_user',
                    'tb_post.id',
                    'tb_user.arroba_user',
                    'tb_user.img_user',
                    'tb_user.nome_user',
                    'tb_post.created_at',
                    'tb_post.updated_at',
                    'tb_post.descricao_post',
                    'tb_post.conteudo_post',
                    'tb_post.repost_id',
                    'tb_seguidores.id',
                    'repost.id',
                    'repost.descricao_post',
                    'repost.conteudo_post',
                    'repost_user.nome_user',
                    'repost_user.arroba_user',
                    'repost_user.img_user',
                    'repost.created_at',
                    'tb_nao_interessado_post.id',
                    'tb_post.area_post',
                    'tb_evento.data_inicio_evento',
                    'tb_evento.data_fim_evento',
                    'tb_evento.id',
                    'tb_post.link_post',
                    'tb_impulsionar.data_fim',
                    'tb_impulsionar.id_post'

                )
                ->selectRaw("
        tb_post.id_user,
        tb_post.id AS id_post,
        tb_user.img_user,
        tb_user.nome_user,
        tb_post.created_at,
        tb_post.updated_at,
        tb_post.descricao_post,
        tb_post.conteudo_post,
        tb_user.arroba_user,
        tb_post.repost_id,
        tb_post.area_post,
        tb_post.link_post,
        repost.id AS repost_post_id,
        repost.descricao_post AS repost_descricao,
        repost.conteudo_post AS repost_conteudo,
        repost_user.nome_user AS repost_autor,
        repost_user.arroba_user AS repost_arroba,
        repost_user.img_user AS repost_img,
        TIMESTAMPDIFF(SECOND, repost.created_at, NOW()) AS tempo_repostado,
        DATE_FORMAT(tb_evento.data_inicio_evento, '%d/%m/%Y') as data_inicio_evento,
        DATE_FORMAT(tb_evento.data_fim_evento, '%d/%m/%Y') as data_fim_evento,  
        tb_evento.id as evento_id,
        COUNT(DISTINCT tb_curtida.id) AS curtidas,
        COUNT(DISTINCT tb_comentario.id) AS comentarios,
       (
    SELECT COUNT(*) 
    FROM tb_post AS reposts 
    WHERE reposts.repost_id = tb_post.id
    AND tb_post.created_at <= now()
) AS total_reposts,
        IF(tb_seguidores.id IS NOT NULL, 1,0) AS segue_usuario,
        TIMESTAMPDIFF(SECOND, tb_post.created_at, NOW()) AS tempo_insercao,
        IF(EXISTS (
            SELECT 1 FROM tb_curtida 
            WHERE tb_curtida.id_post = tb_post.id 
            AND tb_curtida.id_user = $idUser
            AND tb_curtida.status_curtida = 1
        ), 1, 0) AS curtiu_post,

        (COUNT(DISTINCT tb_curtida.id) *1.5
        + IF(tb_seguidores.id IS NOT NULL, 15, 0) 
        + RAND() 
        + IF(tb_post.area_post IN ($preferenciasStr), 20, 0)
        + IF(tb_nao_interessado_post.id IS NOT NULL, -25, 0)
         + IF(tb_post.id_user IN ($usuariosStr), -50, 0)
        + IF(tb_post.area_post IN ($areasStr), -30, 0)
+IF(tb_impulsionar.id_post IS NOT NULL AND tb_impulsionar.data_fim > NOW(), 60, 0)

   + (250000 / (TIMESTAMPDIFF(SECOND, tb_post.created_at, NOW()) + 60))
) AS score,

IF(
    EXISTS (
        SELECT 1 
        FROM tb_instituicao 
        WHERE tb_instituicao.id_user = tb_post.id_user and tb_instituicao.verificado_instituicao = 1
    ), 1, 0
) AS instituicao,
 IF(
  tb_impulsionar.id_post IS NOT NULL 
  AND tb_impulsionar.data_fim > NOW(),
  1, 0
) AS impulsionado


    ");

            $query = DB::table(DB::raw("({$subQuery->toSql()}) as posts"))
                ->mergeBindings($subQuery)
                ->orderByDesc($tipo == 8 ? 'curtidas' : ($tipo == 9 ? 'created_at' : 'score'))
                ->offset($ignorarPosts)
                ->limit($quantidade);

            if ($tipo == 7) {
                $query = $query->where('instituicao', 1);
            }
            $posts = $query->get();

            return response()->json([
                'sucesso' => true,
                'data' => $posts,
                'message' => 'Posts Retornados com Sucesso',
                'code' => 200,
            ]);
        }

        $query = $query
            ->groupBy(
                'tb_post.id_user',
                'tb_post.id',
                'tb_user.arroba_user',
                'tb_user.img_user',
                'tb_user.nome_user',
                'tb_post.created_at',
                'tb_post.updated_at',
                'tb_post.descricao_post',
                'tb_post.conteudo_post',
                'tb_post.repost_id',
                'tb_post.area_post',
                'tb_seguidores.id',
                'repost.id',
                'repost.descricao_post',
                'repost.conteudo_post',
                'repost_user.nome_user',
                'repost_user.arroba_user',
                'repost_user.img_user',
                'repost.created_at',
                'tb_evento.data_inicio_evento',
                'tb_evento.data_fim_evento',
                'tb_evento.id',
                'tb_post.link_post',
                'tb_impulsionar.data_fim',
                'tb_impulsionar.id_post'
            )
            ->selectRaw("
        tb_post.id_user,
        tb_post.id AS id_post,
        tb_user.img_user,
        tb_user.nome_user,
        tb_post.created_at,
        tb_post.updated_at,
        tb_post.descricao_post,
        tb_post.conteudo_post,
        tb_user.arroba_user,
        tb_post.repost_id,
        tb_post.area_post,
        tb_post.link_post,
        repost.id AS repost_post_id,
        repost.descricao_post AS repost_descricao,
        repost.conteudo_post AS repost_conteudo,
        repost_user.nome_user AS repost_autor,
        repost_user.arroba_user AS repost_arroba,
        repost_user.img_user AS repost_img,
        TIMESTAMPDIFF(SECOND, repost.created_at, NOW()) AS tempo_repostado,
        DATE_FORMAT(tb_evento.data_inicio_evento, '%d/%m/%Y') as data_inicio_evento,
        DATE_FORMAT(tb_evento.data_fim_evento, '%d/%m/%Y') as data_fim_evento,
        tb_evento.id as evento_id,
        COUNT(DISTINCT tb_curtida.id) AS curtidas,
        COUNT(DISTINCT tb_comentario.id) AS comentarios,
       (
    SELECT COUNT(*) 
    FROM tb_post AS reposts 
    WHERE reposts.repost_id = tb_post.id
    AND tb_post.created_at <= now()
) AS total_reposts,
        IF(tb_seguidores.id IS NOT NULL, 1,0) AS segue_usuario,
        TIMESTAMPDIFF(SECOND, tb_post.created_at, NOW()) AS tempo_insercao,
        IF(EXISTS (
            SELECT 1 FROM tb_curtida 
            WHERE tb_curtida.id_post = tb_post.id 
            AND tb_curtida.id_user = $idUser
            AND tb_curtida.status_curtida = 1
        ), 1, 0) AS curtiu_post,
IF(
    EXISTS (
        SELECT 1 
        FROM tb_instituicao 
        WHERE tb_instituicao.id_user = tb_post.id_user and tb_instituicao.verificado_instituicao = 1
    ), 1, 0
) AS instituicao,
            IF(
  tb_impulsionar.id_post IS NOT NULL 
  AND tb_impulsionar.data_fim > NOW(),
  1, 0
) AS impulsionado

    ");


        switch ($tipo) {
            case 0:
                $query = $query->orderByDesc('curtidas');
                break;
            case 1:
                break;
            case 2:
                $query = $query->orderByDesc('tb_post.created_at')->where('tb_post.id_user', $pesquisa);
                break;

            case 4:
                $query = $query->where('tb_post.id', $pesquisa);
                break;
            case 5:
                $query = $query->orderByDesc('tb_post.created_at')->where('tb_post.id_user', $pesquisa)->whereNotNull('tb_post.repost_id');
                break;
            case 6:
                $query = $query->orderByDesc('tb_post.created_at')->where('tb_post.id_user', $pesquisa)->whereNotNull('tb_post.conteudo_post');
                break;
            case 10:
                $query = $query->orderByDesc('tb_post.created_at')->where('tb_post.descricao_post', 'like', "%$pesquisa%")->where('tb_post.id_user', $idUser);
                break;
        }

        $posts = $query
            ->offset($ignorarPosts)
            ->limit($quantidade)
            ->where('tb_post.status_post', 1)
            ->where('tb_user.status_user', 1)
            ->where('tb_post.created_at', '<=', now())
            ->get();

        return  response()->json([
            'sucesso' => true,
            'data' => $posts,
            'message' => 'Posts Retornados com Sucesso',
            'code' => 200,
        ]);
    }



    public function indexApi()
    {
        $posts = Post::with('usuario')->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'usuario' => [
                    'nome_user' => $post->usuario->nome_user,
                    'arroba_user' => $post->usuario->arroba_user,
                    'img_user' => $post->usuario->img_user ? url('img/user/fotoPerfil/' . $post->conteudo_post) : null
                ],
                'descricao_post' => $post->descricao_post,
                'criacao_post' => $post->created_at,
                'image_url' => $post->conteudo_post ? url('img/user/imgPosts/' . $post->conteudo_post) : null

            ];
        });


        return response()->json([
            'sucesso' => true,
            'data' => $posts,
            'message' => 'Posts Retornados com Sucesso',
            'code' => 200,

        ]);
    }

    public function getPostsByUser($idUser)
    {
        $query = DB::table('tb_post')
            ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
            ->select(
                'tb_post.id_user',
                'tb_post.id AS id_post',
                'tb_user.img_user',
                'tb_user.nome_user',
                'tb_post.created_at',
                'tb_post.updated_at',
                'tb_post.descricao_post',
                'tb_post.conteudo_post',
                'tb_user.arroba_user',
                DB::raw("TIMESTAMPDIFF(SECOND, tb_post.created_at, NOW()) AS tempo_insercao")
            )
            ->where('tb_post.id_user', '=', $idUser); // Filtro para posts de um usuário específico

        $posts = $query->get();

        return response()->json([
            'sucesso' => true,
            'data' => $posts,
            'message' => 'Posts do usuário retornados com sucesso',
            'code' => 200,
        ]);
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
    public function storeApi(Request $request, $idUser)
    {
        // Verifica se o usuário existe antes de criar o post

        $usuario = User::find($idUser);
        if (!$usuario) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Usuário não encontrado!',
                'code' => 404,
            ]);
        }

        function normalizarTexto($texto)
        {
            $texto = mb_strtolower($texto, 'UTF-8');
            $texto = preg_replace(
                ['/[áàãâä]/u', '/[éèêë]/u', '/[íìîï]/u', '/[óòõôö]/u', '/[úùûü]/u', '/[ç]/u'],
                ['a', 'e', 'i', 'o', 'u', 'c'],
                $texto
            );
            return $texto;
        }

        function identificarAreaPorPontuacao($texto)
        {
            $areas = config('areas');

            $pontuacoes = array_fill_keys(array_keys($areas), 0);

            // Normaliza o texto de entrada e quebra em palavras
            $palavras = explode(' ', normalizarTexto($texto));

            foreach ($palavras as $palavra) {
                foreach ($areas as $area => $keywords) {
                    // Normaliza as palavras-chave também
                    foreach ($keywords as $keyword) {
                        if ($palavra === normalizarTexto($keyword)) {
                            $pontuacoes[$area]++;
                        }
                    }
                }
            }

            arsort($pontuacoes);

            $maiorPontuacao = reset($pontuacoes);
            if ($maiorPontuacao === 0) {
                return 'indefinido';
            }

            return array_key_first($pontuacoes);
        }
        $conteudo = identificarAreaPorPontuacao($request->descricaoPost);

        // Processamento de imagens
        $nomeImagem = null;


        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $extensao = $request->file('img')->getClientOriginalExtension();
            $nomeImagem = time() . '_' . uniqid() . '.' . $extensao;
            $request->file('img')->move(public_path('img/user/imgPosts'), $nomeImagem);
        }

        // Cria o post associado ao usuário
        function pegarHashtags($texto, $idPost)
        {

            $pattern = '/#[\w\d_]+/';
            preg_match_all($pattern, $texto, $hashtags);
            if ($hashtags[0]) {

                for ($i = 0; $i < count($hashtags[0]); $i++) {
                    $hashtag = $hashtags[0][$i];
                    $verificar = Hashtag::where('nomeHashtag', $hashtag)->first();

                    if (!$verificar) {
                        $has = Hashtag::create([
                            'nomeHashtag' => $hashtag,
                            'created_at' => now(),
                            'update_at' => now(),
                        ]);
                        $id = $has->id;
                    } else {
                        $id = $verificar->id;
                    }
                    PostHashtag::create([
                        'id_hashtag' => $id,
                        'id_post' => $idPost,
                        'created_at' => now(),
                        'update_at' => now(),
                    ]);
                }
            }
        }
        if ($request->data && $request->hora) {
            $create_at = "$request->data $request->hora:00";
        } else {
            $create_at = now();
        }
        $post = Post::create([
            'status_post' => 1,
            'conteudo_post' => $nomeImagem,
            'descricao_post' => $request->descricaoPost,
            'repost_id' => $request->repost,
            'link_post' => $request->link,
            'area_post' => $conteudo,
            'id_user' => $idUser,
            'created_at' => $create_at,
            'update_at' => now(),
        ]);
        pegarHashtags($request->descricaoPost, $post->id);
        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Post criado com sucesso!',
            'code' => 200,
            'Post' => $post,
        ]);
    }
    public function criarEvento(Request $request, $idUser)
    {


        $nomeImagem = null;


        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $extensao = $request->file('img')->getClientOriginalExtension();
            $nomeImagem = time() . '_' . uniqid() . '.' . $extensao;
            $request->file('img')->move(public_path('img/user/imgPosts'), $nomeImagem);
        }

        function normalizarTexto1($texto)
        {
            $texto = mb_strtolower($texto, 'UTF-8');
            $texto = preg_replace(
                ['/[áàãâä]/u', '/[éèêë]/u', '/[íìîï]/u', '/[óòõôö]/u', '/[úùûü]/u', '/[ç]/u'],
                ['a', 'e', 'i', 'o', 'u', 'c'],
                $texto
            );
            return $texto;
        }

        function identificarAreaPorPontuacao1($texto)
        {
            $areas = config('areas');

            $pontuacoes = array_fill_keys(array_keys($areas), 0);

            // Normaliza o texto de entrada e quebra em palavras
            $palavras = explode(' ', normalizarTexto1($texto));

            foreach ($palavras as $palavra) {
                foreach ($areas as $area => $keywords) {
                    // Normaliza as palavras-chave também
                    foreach ($keywords as $keyword) {
                        if ($palavra === normalizarTexto1($keyword)) {
                            $pontuacoes[$area]++;
                        }
                    }
                }
            }

            arsort($pontuacoes);

            $maiorPontuacao = reset($pontuacoes);
            if ($maiorPontuacao === 0) {
                return 'indefinido';
            }

            return array_key_first($pontuacoes);
        }
        $conteudo = identificarAreaPorPontuacao1($request->descEvento);
        try {

            $post = Post::create([
                'status_post' => 1,
                'conteudo_post' => $nomeImagem,
                'descricao_post' => $request->tituloEvento,
                'area_post' => $conteudo,
                'id_user' => $idUser,
                'created_at' => now(),
                'update_at' => now(),
            ]);
            $evento = Evento::create([
                'desc_evento' => $request->descEvento,
                'link_evento' => $request->link,
                'data_inicio_evento' => "$request->inicio $request->hinicio:00",
                'data_fim_evento' => "$request->fim $request->hfim:00",
                'status_evento' => 1,
                'id_post' => $post->id,
                'created_at' => now(),
                'update_at' => now(),
            ]);
            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Evento criado com sucesso!',
                'code' => 200,

            ]);
        } catch (error) {
            return response()->json([
                'sucesso' => true,
                'mensagem' => 'erro',
                'code' => 000,
                'Post' => $post,
            ]);
        }
    }
    public function showEvento($id)
    {
        $evento = DB::table('tb_evento')->join('tb_post', 'tb_post.id', '=', 'tb_evento.id_post')->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')->where('tb_evento.id', $id)->get();
        return $evento;
    }
    public function editEvento(Request $request,)
    {
        $evento = Evento::find($request->idEvento);

        if ($evento) {
            // Atualizar o evento
            $evento->update([
                'desc_evento' => $request->descEvento,
                'link_evento' => $request->link,
                'data_inicio_evento' => $request->inicio,
                'data_fim_evento' => $request->fim,
                'status_evento' => 1,
                'updated_at' => now(),
            ]);

            // Buscar o post relacionado a esse evento
            $post = Post::find($evento->id_post);
            $nomeImagem = null;
            if ($request->hasFile('img') && $request->file('img')->isValid()) {

                if ($post->image) {
                    // Deletar a imagem antiga se ela existir
                    $imagePath = public_path('img/user/imgPosts/' . $post->image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                }

                $extensao = $request->file('img')->getClientOriginalExtension();
                $nomeImagem = time() . '_' . uniqid() . '.' . $extensao;

                $request->file('img')->move(public_path('img/user/imgPosts'), $nomeImagem);

                $post->conteudo_post = $nomeImagem;
            }
            function normalizarTexto2($texto)
            {
                $texto = mb_strtolower($texto, 'UTF-8');
                $texto = preg_replace(
                    ['/[áàãâä]/u', '/[éèêë]/u', '/[íìîï]/u', '/[óòõôö]/u', '/[úùûü]/u', '/[ç]/u'],
                    ['a', 'e', 'i', 'o', 'u', 'c'],
                    $texto
                );
                return $texto;
            }

            function identificarAreaPorPontuacao2($texto)
            {
                $areas = config('areas');

                $pontuacoes = array_fill_keys(array_keys($areas), 0);

                // Normaliza o texto de entrada e quebra em palavras
                $palavras = explode(' ', normalizarTexto2($texto));

                foreach ($palavras as $palavra) {
                    foreach ($areas as $area => $keywords) {
                        // Normaliza as palavras-chave também
                        foreach ($keywords as $keyword) {
                            if ($palavra === normalizarTexto2($keyword)) {
                                $pontuacoes[$area]++;
                            }
                        }
                    }
                }

                arsort($pontuacoes);

                $maiorPontuacao = reset($pontuacoes);
                if ($maiorPontuacao === 0) {
                    return 'indefinido';
                }

                return array_key_first($pontuacoes);
            }
            $conteudo = identificarAreaPorPontuacao2($request->descEvento);
            if ($post) {
                $post->update([
                    'status_post' => 1,
                    'descricao_post' => $request->tituloEvento,
                    'area_post' => $conteudo,
                    'updated_at' => now(),
                ]);
                if ($request->hasFile('img') && $request->file('img')->isValid()) {
                    $post->update([
                        'conteudo_post' => $nomeImagem,
                    ]);
                }
            }
        }
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
    public function updateApi(Request $request, $id)
    {
        function normalizarTextoUpdate($texto)
        {
            $texto = mb_strtolower($texto, 'UTF-8');
            $texto = preg_replace(
                ['/[áàãâä]/u', '/[éèêë]/u', '/[íìîï]/u', '/[óòõôö]/u', '/[úùûü]/u', '/[ç]/u'],
                ['a', 'e', 'i', 'o', 'u', 'c'],
                $texto
            );
            return $texto;
        }
        function identificarAreaPorPontuacaoUpdate($texto)
        {
            $areas = config('areas');

            $pontuacoes = array_fill_keys(array_keys($areas), 0);

            // Normaliza o texto de entrada e quebra em palavras
            $palavras = explode(' ', normalizarTextoUpdate($texto));

            foreach ($palavras as $palavra) {
                foreach ($areas as $area => $keywords) {
                    // Normaliza as palavras-chave também
                    foreach ($keywords as $keyword) {
                        if ($palavra === normalizarTextoUpdate($keyword)) {
                            $pontuacoes[$area]++;
                        }
                    }
                }
            }

            arsort($pontuacoes);

            $maiorPontuacao = reset($pontuacoes);
            if ($maiorPontuacao === 0) {
                return 'indefinido';
            }

            return array_key_first($pontuacoes);
        }
        $conteudo = identificarAreaPorPontuacaoUpdate($request->descricaoPost);
        $post = Post::findOrFail($id);

        if ($request->hasFile('img') && $request->file('img')->isValid()) {

            if ($post->image) {
                // Deletar a imagem antiga se ela existir
                $imagePath = public_path('img/user/imgPosts/' . $post->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $extensao = $request->file('img')->getClientOriginalExtension();
            $nomeImagem = time() . '_' . uniqid() . '.' . $extensao;

            $request->file('img')->move(public_path('img/user/imgPosts'), $nomeImagem);

            $post->conteudo_post = $nomeImagem;
        }
        $post->descricao_post = $request->descricaoPost;
        $post->updated_at = now();
        $post->area_post = $conteudo;
        if ($request->link) {
            $post->link_post = $request->link;
        }
        $post->save();

        return $request->descricaoPost;
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
    public function interacoes(Request   $request, $acao)
    {
        $resposta = "erro";
        switch ($acao) {
            case 'curtir':
                $curtida = Curtida::create([
                    'id_user' => $request->idUser,
                    'id_post' => $request->idPost,
                    'status_curtida' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $resposta = "Post curtido com sucesso";
                break;

            case 'descurtir':
                $curtida = Curtida::select('id')
                    ->where('id_user', $request->idUser)
                    ->where('id_post', $request->idPost)
                    ->delete();

                $resposta = "Post descurtido com sucesso";

                break;

            case 'comentar':
                $comentario = Comentario::create([
                    'id_user' => $request->idUser,
                    'id_post' => $request->idPost,
                    'comentario' => $request->comentario,
                    'status_comentario' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $usuario = User::select('id', 'arroba_user', 'img_user')->where('id', $request->idUser)->get();
                return response()->json([

                    'usuario' => $usuario,
                    'comentario' => $comentario,

                ]);

                break;

            case 'comentarios':
                $comentarios = Comentario::with(['usuario'])
                    ->where('id_post', $request->idPost)
                    ->select(
                        '*',
                        DB::raw('TIMESTAMPDIFF(SECOND, created_at, NOW()) AS tempo_insercao'),
                        DB::raw('(SELECT COUNT(*) FROM tb_curtida_comentario WHERE tb_curtida_comentario.id_comentario = tb_comentario.id) AS total_curtidas'),
                        DB::raw("EXISTS (
            SELECT 1 FROM tb_curtida_comentario 
            WHERE tb_curtida_comentario.id_comentario = tb_comentario.id 
            AND tb_curtida_comentario.id_user = $request->idUser
        ) AS curtiu")
                    )
                    ->orderByDesc('total_curtidas')
                    ->get();
                $resposta = $comentarios;
                break;
            case 'curtirComentario':
                try {
                    if ($request->acao == 'curtir') {
                        CurtidaComentario::create([
                            'id_user' => $request->idUser,
                            'id_comentario' => $request->idComentario,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $resposta = "Comentario curtido com sucesso";
                    } elseif ($request->acao == 'descurtir') {
                        CurtidaComentario::where('id_user', $request->idUser)->where('id_comentario', $request->idComentario)->delete();
                        $resposta = "Comentario descurtir com sucesso";
                    }
                } catch (Error) {
                    $resposta = "Error";
                }
                break;
            case 'denunciar':
                $dadosDenuncia = [
                    'motivo_denuncia' => $request->motivo,
                    'id_user_denunciador' => $request->idUser,
                    'id_user_denunciado' => $request->denunciado,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if ($request->idPost != 'undefined') {
                    $dadosDenuncia['id_post_denunciado'] = $request->idPost;
                }

                Denuncia::create($dadosDenuncia);
                $verificar = Bloqueado::select('id')->where('id_user_bloqueado', $request->denunciado)->where('id_user_bloqueando', $request->idUser)->get();
                if ($verificar->isEmpty()) {
                    Bloqueado::create([
                        'id_user_bloqueado' => $request->denunciado,
                        'id_user_bloqueando' => $request->idUser,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $resposta = "usuario bloqueado com sucesso";
                } else {
                    $resposta = "Usuario já esta bloqueado";
                }
                $resposta = 'denuncia feita com sucesso';
                break;

            case 'seguir':
                $verificarSeguidor = Seguidores::select('id')->where('id_user_seguido', $request->userPost)->where('id_user_seguidor', $request->idUser)->get();
                if ($verificarSeguidor->isEmpty()) {
                    Seguidores::create([
                        'id_user_seguido' => $request->userPost,
                        'id_user_seguidor' => $request->idUser,
                        'status_seguidores' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $resposta = 'seguido';
                } else {
                    Seguidores::select('id')->where('id_user_seguido', $request->userPost)->where('id_user_seguidor', $request->idUser)->delete();
                    $resposta = 'deseguido';
                }
                break;
            case 'bloquear':
                $verificar = Bloqueado::select('id')->where('id_user_bloqueado', $request->userPost)->where('id_user_bloqueando', $request->idUser)->get();
                if ($verificar->isEmpty()) {
                    Bloqueado::create([
                        'id_user_bloqueado' => $request->userPost,
                        'id_user_bloqueando' => $request->idUser,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $resposta = "usuario bloqueado com sucesso";
                } else {
                    $resposta = "Usuario já esta bloqueado";
                }
                break;
            case 'naointeressado':
                $verificar = NaoInteressado::select('id')->where('id_user', $request->idUser)->where('id_post', $request->idPost)->get();
                if ($verificar->isEmpty()) {
                    NaoInteressado::create([
                        'id_user' => $request->idUser,
                        'id_post' => $request->idPost,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $resposta = "post setado como não interessado";
                } else {
                    $resposta = "post já está setado como não interessado";
                }

                break;
            case 'desativar':
                $post = post::findOrFail($request->idPost);
                $post->status_post = 0;
                $post->save();
                $resposta = 'post desativado com sucesso';
                break;
        }
        return $resposta;
    }
    public function impulsionar(Request   $request)
    {


       try {
   
    Impulsionar::where('id_post', $request->idPost)->delete();

   
    Impulsionar::create([
        'id_post' => $request->idPost,
        'data_fim' => now()->addDays($request->dias),
    ]);
    return "Sucesso";
} catch (\Throwable $e) {
    return "Erro";
}
    }
}
