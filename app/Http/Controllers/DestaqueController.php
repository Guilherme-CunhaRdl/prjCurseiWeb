<?php

namespace App\Http\Controllers;

use App\Models\Destaque;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DestaqueController extends Controller
{
    public function index($id_user)
    {
        // Busca destaques do usuário
        $destaques = Destaque::with(['story.user'])
            ->where('id_user', $id_user)
            ->orderBy('data_destaque', 'desc')
            ->get()
            ->map(function ($destaque) {
                return [
                    'id_destaque' => $destaque->id_destaque,
                    'data_destaque' => $destaque->data_destaque,
                    'foto_destaque' => $destaque->foto_destaque,
                    'story' => $this->formatStory($destaque->story)
                ];
            });

        // Busca stories do usuário que ainda não foram destacados
        $stories = Story::with('user')
            ->where('id_user', $id_user)
            ->whereNotIn('id', Destaque::where('id_user', $id_user)->pluck('id_story'))
            ->get()
            ->map(function ($story) {
                return $this->formatStory($story);
            });

        return response()->json([
            'success' => true,
            'data' => [
                'destaques' => $destaques,
                'stories_nao_destacados' => $stories
            ]
        ]);
    }

public function store($id_user, $id_story)
{
    try {
        // Verifica se o story pertence ao usuário
        $story = Story::with('user')
                    ->where('id', $id_story)
                    ->where('id_user', $id_user)
                    ->firstOrFail();

        // Verifica se já foi destacado
        if (Destaque::where('id_story', $id_story)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Este story já foi destacado'
            ], 400);
        }

        // Usa a imagem do story como foto_destaque
        $fotoDestaque = $story->conteudo_storyes;
        
        // Cria o destaque com a foto definida
        $destaque = Destaque::create([
            'id_user' => $id_user,
            'id_story' => $id_story,
            'data_destaque' => Carbon::now(),
            'foto_destaque' => $fotoDestaque, // Valor definido
            'status_destaque' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Story destacado com sucesso!',
            'data' => [
                'id_destaque' => $destaque->id_destaque,
                'data_destaque' => $destaque->data_destaque,
                'foto_destaque' => url($destaque->foto_destaque),
                'status_destaque' => $destaque->status_destaque,
                'story' => $this->formatStory($story)
            ]
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao destacar story',
            'error' => $e->getMessage()
        ], 500);
    }
}
    public function destroy($id_user, $id_destaque)
    {
        try {
            // Busca o destaque verificando o id_user
            $destaque = Destaque::where('id_destaque', $id_destaque)
                          ->where('id_user', $id_user)
                          ->firstOrFail();

            // Remove a foto se existir
            if ($destaque->foto_destaque && file_exists(public_path($destaque->foto_destaque))) {
                unlink(public_path($destaque->foto_destaque));
            }

            $destaque->delete();

            return response()->json([
                'success' => true,
                'message' => 'Destaque removido com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover destaque',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Formata as informações do story de forma consistente
     */
    private function formatStory($story)
    {
        return [
            'id' => $story->id,
            'conteudo_storyes' => $story->conteudo_storyes,
            'url_completa' => url($story->conteudo_storyes),
            'tipo_midia' => $story->tipo_midia,
            'data_inicio' => $story->data_inicio,
            'legenda' => $story->legenda,
            'status_storyes' => $story->status_storyes, // Adicione esta linha
            'id_user' => $story->id_user,
            'user' => [
                'id' => $story->user->id,
                'nome' => $story->user->nome_user,
                'foto' => $story->user->img_user ? url('/img/user/fotoPerfil/' . $story->user->img_user) : null
            ]
        ];
    }
}