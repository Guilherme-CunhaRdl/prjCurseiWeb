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
        $destaques = Destaque::with(['user', 'stories']) // Note o plural
            ->where('id_user', $id_user)
            ->orderBy('data_destaque', 'desc')
            ->get()
            ->map(function ($destaque) {
                return [
                    'id' => $destaque->id,
                    'data_destaque' => $destaque->data_destaque,
                    'foto_destaque' => $destaque->foto_destaque,
                    'stories' => $destaque->stories->map(function ($story) {
                        return $this->formatStory($story);
                    })
                ];
            });

        $stories = Story::where('id_user', $id_user)
            ->get()
            ->map(function ($story) {
                return $this->formatStory($story);
            });

        return response()->json([
            'success' => true,
            'data' => [
                'destaques' => $destaques,
                'stories' => $stories
            ]
        ]);
    }

public function store(Request $request, $id_user)
{
    try {
        $validator = Validator::make($request->all(), [
            'stories' => 'required|array|min:1',
            'stories.*' => 'integer|exists:tb_storyes,id,id_user,'.$id_user
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422);
        }

        // Busca o primeiro story para usar como thumbnail
        $firstStory = Story::find($request->input('stories')[0]);
        
        // Cria novo destaque
        $destaque = Destaque::create([
            'id_user' => $id_user,
            'data_destaque' => Carbon::now(),
            'foto_destaque' => $firstStory->conteudo_storyes, // Usa a imagem do primeiro story
            'status_destaque' => 1
        ]);

        // Associa os stories ao destaque
        $destaque->stories()->attach($request->input('stories'));

        // Carrega relacionamentos para a resposta
        $destaque->load('stories.user');

        return response()->json([
            'success' => true,
            'message' => 'Destaque criado com sucesso!',
            'data' => [
                'id' => $destaque->id,
                'data_destaque' => $destaque->data_destaque,
                'foto_destaque' => url($destaque->foto_destaque),
                'stories' => $destaque->stories->map(function ($story) {
                    return $this->formatStory($story);
                })
            ]
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao criar destaque',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function destroy($id_user, $id)
    {
        try {
            // Busca o destaque verificando o id_user
            $destaque = Destaque::where('id', $id)
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
            'id_user' => $story->id_user,
            'user' => [
                'id' => $story->user->id,
                'nome' => $story->user->nome_user,
                'foto' => $story->user->img_user ? url('/img/user/fotoPerfil/' . $story->user->img_user) : null
            ]
        ];
    }

public function addStories(Request $request, $id_destaque)
{
    try {
        // Carrega relacionamento para evitar N+1
        $destaque = Destaque::with('stories')->findOrFail($id_destaque);
        
        $validator = Validator::make($request->all(), [
            'stories' => 'required|array|min:1',
            'stories.*' => [
                'integer',
                'exists:tb_storyes,id',
                // Valida se o story pertence ao usuário do destaque
                function ($attribute, $value, $fail) use ($destaque) {
                    $story = Story::find($value);
                    if (!$story || $story->id_user !== $destaque->id_user) {
                        $fail("O story $value não pertence ao usuário do destaque.");
                    }
                }
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Filtra stories que já não estão no destaque
        $existingStories = $destaque->stories->pluck('id')->toArray();
        $newStories = array_diff($request->input('stories'), $existingStories);

        if (empty($newStories)) {
            return response()->json([
                'success' => false,
                'message' => 'Todos os stories já estão no destaque'
            ], 400);
        }

        // Adiciona apenas os novos stories
        $destaque->stories()->attach($newStories);

        return response()->json([
            'success' => true,
            'message' => 'Stories adicionados ao destaque!',
            'stories_adicionados' => array_values($newStories)
        ]);

    } catch (\Exception $e) {
        // Log do erro para depuração
        \Log::error('Erro ao adicionar stories: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Erro ao adicionar stories',
            'error' => $e->getMessage(),
            'trace' => env('APP_DEBUG') ? $e->getTrace() : []
        ], 500);
    }
}

}