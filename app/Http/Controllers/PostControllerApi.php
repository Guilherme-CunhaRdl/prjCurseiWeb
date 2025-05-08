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
        ->leftJoin('tb_comentario', 'tb_post.id', '=', 'tb_comentario.id_post');
        // isso serve para verificar se foi passado o valor do id ,se n foi passado ele n faz a comparação pelo id--- resumindo ele ver se ta logado ou não
        if ($idUser !== 0) {

            $query = $query->leftJoin('tb_seguidores', function ($join) use ($idUser) {
                $join->on('tb_seguidores.id_user_seguidor', '=', DB::raw($idUser))
                    ->on('tb_seguidores.id_user_seguido', '=', 'tb_post.id_user');
            });
            $query = $query->leftJoin('tb_bloqueado as bloqueio1', function ($join) use ($idUser) {
                $join->on('bloqueio1.id_user_bloqueado', '=', 'tb_post.id_user')
                    ->where('bloqueio1.id_user_bloqueando', '=', DB::raw($idUser));
            });

            $query = $query->leftJoin('tb_bloqueado as bloqueio2', function ($join) use ($idUser) {
                $join->on('bloqueio2.id_user_bloqueando', '=', 'tb_post.id_user')
                    ->where('bloqueio2.id_user_bloqueado', '=', DB::raw($idUser));
            });

            $query = $query->whereNull('bloqueio1.id')->whereNull('bloqueio2.id');
        };
        $query = $query
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
            'tb_post.repost_id',
        
            // Dados do post original (repostado)
            'repost.id AS repost_post_id',
            'repost.descricao_post AS repost_descricao',
            'repost.conteudo_post AS repost_conteudo',
            'repost_user.nome_user AS repost_autor',
            'repost_user.arroba_user AS repost_arroba',
            'repost_user.img_user AS repost_img',
            DB::raw("TIMESTAMPDIFF(SECOND, repost.created_at, NOW()) AS tempo_repostado"),
        
            DB::raw('COUNT(DISTINCT tb_curtida.id) AS curtidas'),
            DB::raw('COUNT(DISTINCT tb_comentario.id) AS comentarios'),
            DB::raw('IF(tb_seguidores.id IS NOT NULL, 1,0) AS segue_usuario'),
            DB::raw("TIMESTAMPDIFF(SECOND, tb_post.created_at, NOW()) AS tempo_insercao"),

            DB::raw("IF(EXISTS (
                SELECT 1 FROM tb_curtida 
                WHERE tb_curtida.id_post = tb_post.id 
                  AND tb_curtida.id_user = $idUser
                  AND tb_curtida.status_curtida = 1
            ), 1, 0) AS curtiu_post"),
            DB::raw('(COUNT(DISTINCT tb_curtida.id) + IF(tb_seguidores.id IS NOT NULL, 10, 0) + RAND()) AS score')
        )
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
        
            // Campos do repost
            'repost.id',
            'repost.descricao_post',
            'repost.conteudo_post',
            'repost_user.nome_user',
            'repost_user.arroba_user',
            'repost_user.img_user',
             'repost.created_at'
        );
        switch ($tipo) {
            case 0:
                $query = $query->orderByDesc('curtidas');
                break;
            case 1:
                $query = $query->orderByDesc('score');
                break;
            case 2:
                $query = $query->orderByDesc('tb_post.created_at')->where('tb_post.id_user', $idUser);
                break;
            case 3:
                $query = $query->orderByDesc('curtidas')
                    ->where('tb_user.arroba_user', 'like', "%$pesquisa%")
                    ->orWhere('tb_user.nome_user', 'like', "%$pesquisa%")
                    ->orWhere('tb_post.descricao_post', 'like', "%$pesquisa%");
                break;
            case 4:
                $query = $query->where('tb_post.id',$idUser);
        }

        $posts = $query
        ->offset($ignorarPosts)
        ->limit($quantidade)
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


        // Processamento de imagens
        $nomeImagem = null;


        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $extensao = $request->file('img')->getClientOriginalExtension();
            $nomeImagem = time() . '_' . uniqid() . '.' . $extensao;
            $request->file('img')->move(public_path('img/user/imgPosts'), $nomeImagem);
        }

        // Cria o post associado ao usuário
        $post = Post::create([
            'status_post' => 1,
            'conteudo_post' => $nomeImagem, 
            'descricao_post' => $request->descricaoPost,
            'repost_id' =>$request->repost,
            // 'titulo_post' => $request->tituloPost,
            'id_user' => $idUser, 
            'created_at' => now(),
            'update_at' => now(),
        ]);

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Post criado com sucesso!',
            'code' => 200,
            'Post' => $post,
        ]);
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
                $resposta = $usuario;

                break;

            case 'comentarios':
                $comentarios = Comentario::with(['usuario'])->where('id_post', $request->idPost)->get();
                $resposta = $comentarios;
                break;

            case 'denunciar':
                Denuncia::create([
                    'motivo_denuncia' => $request->motivo,
                    'id_post_denunciado' => $request->idPost,
                    'id_user_denunciador' => $request->idUser,
                    'id_user_denunciado' => $request->denunciado,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
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
                    $resposta = 'usuário segudo com sucesso';
                } else {
                    Seguidores::select('id')->where('id_user_seguido', $request->userPost)->where('id_user_seguidor', $request->idUser)->delete();
                    $resposta = 'usuário deseguido com sucesso';
                }
                break;
            case 'bloquear':
                Bloqueado::create([
                    'id_user_bloqueado' => $request->userPost,
                    'id_user_bloqueando' => $request->idUser,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $resposta = "usuario bloqueado com sucesso";
                break;
        }
        return $resposta;
    }
}
