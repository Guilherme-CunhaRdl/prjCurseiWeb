<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ExplorarController extends Controller
{
    public function maisUsadas()
    {
        $postCounts = DB::table('tb_post_hashtag')
            ->select('id_hashtag', DB::raw('COUNT(*) as total'))
            ->groupBy('id_hashtag');

        $curteiCounts = DB::table('tb_curtei_hashtag')
            ->select('id_hashtag', DB::raw('COUNT(*) as total'))
            ->groupBy('id_hashtag');

        // União das duas contagens
        $hashtagCounts = DB::table(DB::raw("({$postCounts->toSql()}) as p"))
            ->mergeBindings($postCounts)
            ->unionAll($curteiCounts);

        $totais = DB::table(DB::raw("({$hashtagCounts->toSql()}) as t"))
            ->mergeBindings($hashtagCounts)
            ->select('id_hashtag', DB::raw('SUM(total) as total_uso'))
            ->groupBy('id_hashtag')
            ->orderByDesc('total_uso')
            ->take(10) 
            ->get();

        $resultados = $totais->map(function ($item) {
            $hashtag = Hashtag::find($item->id_hashtag);
            return [
                'hashtag' => $hashtag->nomeHashtag,
                'usos' => $item->total_uso,
            ];
        });

        return response()->json($resultados);
    }

    public function maisRecentes(){
        
    }   

    public function buscar(Request $request) {
        $termoPesquisado = $request->input('termoPesquisado');
    
        $usuarios = User::where('nome_user', 'like', "%$termoPesquisado%")
            ->orWhere('arroba_user', 'like', "%$termoPesquisado%")
            ->get();
    
        $posts = Post::where('descricao_post', 'like', "%$termoPesquisado%")
            ->get();
    
        $hashtags = Hashtag::where('nomeHashtag', 'like', "%$termoPesquisado%")
            ->get();
    
        return response()->json([
            'usuarios' => $usuarios,
            'posts' => $posts,
            'hashtags' => $hashtags,
        ]);
    }
    
}
