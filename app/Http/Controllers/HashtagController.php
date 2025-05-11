<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagController extends Controller
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
            ->take(10) // top 10, por exemplo
            ->get();

        // Pega os nomes das hashtags
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
}
