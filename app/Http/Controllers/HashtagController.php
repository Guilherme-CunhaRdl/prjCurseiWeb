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

    public function recomendarHashtags($idUser)
    {



        // Primeiro, obtemos as preferências do usuário
        $userPreferences = DB::table('tb_user_preferencia')
            ->where('id_user', $idUser)
            ->pluck('preferencia')
            ->toArray();

        // Se não houver preferências, usar array vazio para evitar erro no SQL
        $preferencesList = !empty($userPreferences) ? $userPreferences : ['Indefinido'];

        $recommendedHashtags = DB::table('tb_hashtag as h')
            ->select(
                'h.id',
                'h.nomeHashtag',
                DB::raw('(SELECT COUNT(*) FROM tb_post_hashtag ph 
                     JOIN tb_post p ON ph.id_post = p.id 
                     WHERE ph.id_hashtag = h.id AND p.id_user = ' . $idUser . ') * 5 AS user_usage_score'),
                DB::raw('(SELECT COUNT(DISTINCT ph.id_post) FROM tb_post_hashtag ph
                     JOIN tb_post p ON ph.id_post = p.id
                     JOIN tb_seguidores s ON p.id_user = s.id_user_seguido
                     WHERE ph.id_hashtag = h.id AND s.id_user_seguidor = ' . $idUser . ' AND s.status_seguidores = 1) * 4 AS following_usage_score'),
                DB::raw('(SELECT COUNT(DISTINCT ph.id_post) FROM tb_post_hashtag ph
                     JOIN tb_post p ON ph.id_post = p.id
                     WHERE ph.id_hashtag = h.id AND p.area_post IN ("' . implode('","', $preferencesList) . '")) * 3 AS interest_score'),
                DB::raw('((SELECT COUNT(DISTINCT ph.id_post) FROM tb_post_hashtag ph
                      JOIN tb_comentario c ON ph.id_post = c.id_post
                      WHERE ph.id_hashtag = h.id AND c.id_user = ' . $idUser . ') +
                     (SELECT COUNT(DISTINCT ph.id_post) FROM tb_post_hashtag ph
                      JOIN tb_post p ON ph.id_post = p.id
                      WHERE ph.id_hashtag = h.id AND p.repost_id IN 
                        (SELECT id FROM tb_post WHERE id_user = ' . $idUser . '))) * 2 AS interaction_score'),
                DB::raw('
                (SELECT COUNT(*) FROM tb_post_hashtag ph 
                 JOIN tb_post p ON ph.id_post = p.id 
                 WHERE ph.id_hashtag = h.id AND p.id_user = ' . $idUser . ') * 5 +
                (SELECT COUNT(DISTINCT ph.id_post) FROM tb_post_hashtag ph
                 JOIN tb_post p ON ph.id_post = p.id
                 JOIN tb_seguidores s ON p.id_user = s.id_user_seguido
                 WHERE ph.id_hashtag = h.id AND s.id_user_seguidor = ' . $idUser . ' AND s.status_seguidores = 1) * 4 +
                (SELECT COUNT(DISTINCT ph.id_post) FROM tb_post_hashtag ph
                 JOIN tb_post p ON ph.id_post = p.id
                 WHERE ph.id_hashtag = h.id AND p.area_post IN ("' . implode('","', $preferencesList) . '")) * 3 +
                ((SELECT COUNT(DISTINCT ph.id_post) FROM tb_post_hashtag ph
                  JOIN tb_comentario c ON ph.id_post = c.id_post
                  WHERE ph.id_hashtag = h.id AND c.id_user = ' . $idUser . ') +
                 (SELECT COUNT(DISTINCT ph.id_post) FROM tb_post_hashtag ph
                  JOIN tb_post p ON ph.id_post = p.id
                  WHERE ph.id_hashtag = h.id AND p.repost_id IN 
                    (SELECT id FROM tb_post WHERE id_user = ' . $idUser . '))) * 2
                AS total_score')
            )
           
            ->orderByDesc('total_score')
            ->limit(5)
            ->get();

        return $recommendedHashtags;
    }
}
