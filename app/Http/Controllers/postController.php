<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Curtida;
use App\Models\Hashtag;
use App\Models\Repostar;
use App\Models\Comentario;
use Illuminate\Support\Facades\DB;

class postController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalCurtidas = Curtida::count();
        $totalPosts = Post::count();
        $totalComentarios = Comentario::count(); 
        $postsPorDia = DB::table('tb_post')
            ->selectRaw('DAYOFWEEK(created_at) as dia_semana, COUNT(*) as total')
            ->groupBy('dia_semana')
            ->orderBy('dia_semana')
            ->get();

        $postsInstituicao = DB::table('tb_post')
            ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
            ->join('tb_instituicao', 'tb_user.id', '=', 'tb_instituicao.id_user')
            ->count('tb_post.id');

        $postUsers = DB::table('tb_post')
            ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
            ->leftJoin('tb_instituicao', 'tb_user.id', '=', 'tb_instituicao.id_user')
            ->whereNull('tb_instituicao.id_user')
            ->count('tb_post.id');

        function porcentagem($valor,$total){
            $resultado =number_format(($valor / $total) * 100,1,',','.');
            return $resultado;
        }
        $porcentagemUser = porcentagem($postUsers,$totalPosts);
        $porcentagemInst = porcentagem($postsInstituicao,$totalPosts);

        $postsDia = Post::whereRaw('HOUR(created_at) BETWEEN   6 and 18')->count();
        $postsNoite = Post::whereRaw('HOUR(created_at) >= 18 OR HOUR(created_at) < 6')->count();
        $porcentagemNoite = porcentagem($postsNoite,$totalPosts);
        $porcentagemDia = porcentagem($postsDia,$totalPosts);
        $posts = Post::with(['usuario', 'curtidas'])
        ->withCount('curtidas')
        ->withCount('comentario')
        ->orderByDesc('curtidas_count')
        ->limit(3)
        ->get();

        
        $topHashtags = Hashtag::withCount('posts')
    ->orderByDesc('posts_count')
    ->take(5)
    ->get();

    $totalReposts = Repostar::count();
        return view('area-adm.posts')
            ->with('totalCurtidas', $totalCurtidas)
            ->with('totalPosts', $totalPosts)
            ->with('totalComentarios', $totalComentarios)
            ->with('postsPorDia', $postsPorDia)
            ->with('postsInstituicao', $postsInstituicao)
            ->with('postUsers', $postUsers)
            ->with('porcentagemUser', $porcentagemUser)
            ->with('porcentagemInst', $porcentagemInst)
            ->with('postsDia', $postsDia)
            ->with('postsNoite', $postsNoite)
            ->with('porcentagemNoite', $porcentagemNoite)
            ->with('porcentagemDia', $porcentagemDia)
            ->with('topPosts', $posts)
            ->with('topHashtags', $topHashtags)
            ->with('totalReposts', $totalReposts)
        ;
    }


    public function filter(Request $request)
    {
        try {

          \DB::enableQueryLog();
            $query = Post::with(['usuario', 'comentario'])
                        ->withCount(['comentario', 'curtidas']);
    
          
            if ($request->search) {
                $query->whereHas('usuario', function($q) use ($request) {
                    $q->where('nome_user', 'like', '%'.$request->search.'%')
                      ->orWhere('arroba_user', 'like', '%'.$request->search.'%');
                });
            }
    
            if ($request->status === 'ativos') {
                $query->where('status_post', true);
            } elseif ($request->status === 'desativados') {
                $query->where('status_post', false);
            }
    
        
            switch($request->sort) {
                case 'views': $query->orderBy('views', 'desc'); break;
                case 'likes': $query->orderBy('curtidas_count', 'desc'); break;
                case 'recentes': $query->orderBy('created_at', 'desc'); break;
                case 'antigos': $query->orderBy('created_at', 'asc'); break;
                default: $query->orderBy('created_at', 'desc');
            }
    
            $posts = $query->get();
    
            return response()->json([
                'success' => true,
                'posts' => $posts
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
