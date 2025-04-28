<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;



class PostControllerApi extends Controller
{
    public function posts($tipo,$idUser,$quantidade,$pagina,$pesquisa)
    {
        $ignorarPosts = 0;
        for ($i = 0; $i <= $pagina; $i++){
            $ignorarPosts = $ignorarPosts + $quantidade;    
        };
        $ignorarPosts = $ignorarPosts - $quantidade;

        $query =  DB::table('tb_post')
            ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
            ->leftJoin('tb_curtida', 'tb_post.id', '=', 'tb_curtida.id_post')
            ->leftJoin('tb_comentario', 'tb_post.id', '=', 'tb_comentario.id_post');
            // isso serve para verificar se foi passado o valor do id ,se n foi passado ele n faz a comparação pelo id--- resumindo ele ver se ta logado ou não
            if($idUser !== 0){

                $query = $query->leftJoin('tb_seguidores', function ($join) use ($idUser) {
                    $join->on('tb_seguidores.id_user_seguidor', '=', DB::raw($idUser))
                         ->on('tb_seguidores.id_user_seguido', '=', 'tb_post.id_user');
                });
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
                DB::raw('COUNT(DISTINCT tb_curtida.id) AS curtidas'),
                DB::raw('COUNT(DISTINCT tb_comentario.id) AS comentarios'),
                DB::raw('IF(tb_seguidores.id IS NOT NULL, 1,0) AS segue_usuario'),
                DB::raw("TIMESTAMPDIFF(SECOND, tb_post.created_at, NOW()) AS tempo_insercao")
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
                'tb_seguidores.id'
            );
        switch ($tipo) {
            case 0:
                $query = $query->orderByDesc('curtidas')
                ->offset($ignorarPosts)
                ->limit($quantidade)

                ;
                break;
            case 1:
                $query = $query->orderByDesc('segue_usuario')
                ->offset($ignorarPosts)
                ->limit($quantidade)
                ;
                break;
            case 2:
                $query = $query->orderByDesc('tb_post.created_at')->where('tb_post.id_user',$idUser)
                ->offset($ignorarPosts)
                ->limit($quantidade);
                break;
            case 3:
                $query = $query->orderByDesc('curtidas')
                ->where('tb_user.arroba_user','like',"%$pesquisa%" )
                ->orWhere('tb_user.nome_user', 'like', "%$pesquisa%")
                ->orWhere('tb_post.descricao_post', 'like', "%$pesquisa%")
                ->offset($ignorarPosts)
                ->limit($quantidade);
                break;
        }

        $posts = $query->get();

        return  response()->json([
            'sucesso' => true,
            'data' => $posts,
            'message' => 'Posts Retornados com Sucesso',
            'code' => 200,

        ]);
    }


    public function indexApi()
    {
        $posts = Post::with('usuario')->get()->map(function ($post){
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
    public function create()
    {
        
    }

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

    $nomeImagem = null;

    if ($request->hasFile('conteudoPost') && $request->file('conteudoPost')->isValid()) {
        $extensao = $request->conteudoPost->extension();
        $nomeImagem = md5($request->conteudoPost->getClientOriginalName() . microtime()) . '.' . $extensao;
        $request->conteudoPost->move(public_path('img/user/fotoPerfil/'), $nomeImagem);
    }

    // Cria o post associado ao usuário
    $post = Post::create([
        'status_post' => $request->statusPost,
        'conteudo_post' => $nomeImagem, // Salva o nome do arquivo gerado
        'descricao_post' => $request->descricaoPost,
        'titulo_post' => $request->tituloPost,
        'id_user' => $idUser, // Associa o post ao ID do usuário correto
        'created_at' => now(),
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
}