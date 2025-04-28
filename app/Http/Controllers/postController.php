<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Curtida;
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
        $posts = Post::with(['usuario', 'curtidas'])->withCount('curtidas')->orderByDesc('curtidas_count')->limit(3)->get();
        
        return view('area-adm.posts')
            ->with('totalCurtidas', $totalCurtidas)
            ->with('totalPosts', $totalPosts)
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
        ;
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
