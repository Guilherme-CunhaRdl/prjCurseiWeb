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
        // Carregar destaque com stories e usuário dos stories
        $destaques = Destaque::with(['stories.user'])
            ->where('id_user', $id_user)
            ->orderBy('data_destaque', 'desc')
            ->get()
            ->map(function ($destaque) {
                return [
                    'id' => $destaque->id,
                    'titulo_destaque' => $destaque->titulo_destaque,
                    'data_destaque' => $destaque->data_destaque,
                    'foto_destaque' => $this->getFullUrl($destaque->foto_destaque),
                    'stories' => $destaque->stories->map(function ($story) {
                        return $this->formatStory($story);
                    })
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $destaques
        ]);
    }

    public function listStories($id_user)
    {
        try {
            $stories = Story::where('id_user', $id_user)
                ->orderBy('data_inicio', 'desc')
                ->get()
                ->map(function ($story) {
                    return [
                        'id' => $story->id,
                        'conteudo_storyes' => $this->getFullUrl($story->conteudo_storyes),
                        'tipo_midia' => $story->tipo_midia,
                        'data_inicio' => $story->data_inicio,
                        'legenda' => $story->legenda,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'stories' => $stories
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar stories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request, $id_user)
    {
        try {
            $validator = Validator::make($request->all(), [
                'stories' => 'required|array|min:1',
                'stories.*' => 'integer|exists:tb_storyes,id,id_user,'.$id_user,
                'titulo_destaque' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro de validação',
                    'errors' => $validator->errors()
                ], 422);
            }

            $firstStory = Story::find($request->input('stories')[0]);
            
            $destaque = Destaque::create([
                'id_user' => $id_user,
                'titulo_destaque' => $request->titulo_destaque,
                'data_destaque' => Carbon::now(),
                'foto_destaque' => $firstStory->conteudo_storyes,
                'status_destaque' => 1
            ]);

            $destaque->stories()->attach($request->input('stories'));
            
            // Carregar relações para resposta
            $destaque->load('stories.user');

            return response()->json([
                'success' => true,
                'message' => 'Destaque criado com sucesso!',
                'data' => [
                    'id' => $destaque->id,
                    'titulo_destaque' => $destaque->titulo_destaque,
                    'data_destaque' => $destaque->data_destaque,
                    'foto_destaque' => $this->getFullUrl($destaque->foto_destaque),
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
            $destaque = Destaque::where('id', $id)
                          ->where('id_user', $id_user)
                          ->firstOrFail();

            // Não remover arquivos físicos (os stories são compartilhados)
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
    
    private function formatStory($story)
    {
        return [
            'id' => $story->id,
            'conteudo_storyes' => $story->conteudo_storyes,
            'url_completa' => $this->getFullUrl($story->conteudo_storyes),
            'tipo_midia' => $story->tipo_midia,
            'data_inicio' => $story->data_inicio,
            'legenda' => $story->legenda,
            'id_user' => $story->id_user,
            'user' => [
                'id' => $story->user->id,
                'nome' => $story->user->nome_user,
                'foto' => $this->getFullUrl($story->user->img_user, 'user')
            ]
        ];
    }

    private function getFullUrl($path, $type = 'default')
    {
        if (!$path) {
            return null;
        }

        // Se já é uma URL completa
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Determinar base path baseado no tipo
        $base = $type === 'user' 
            ? url('/img/user/fotoPerfil/') 
            : url('/');

        return $base . '/' . ltrim($path, '/');
    }

    public function atualizarDestaques(Request $request, $id_destaque)
    {
        try {
            $destaque = Destaque::with('stories')->findOrFail($id_destaque);
            
            $validator = Validator::make($request->all(), [
                'stories' => 'required|array',
                'stories.*' => [
                    'integer',
                    function ($attribute, $value, $fail) use ($destaque) {
                        $story = Story::find($value);
                        if (!$story || $story->id_user != $destaque->id_user) {
                            $fail("O story #$value não existe ou não pertence ao usuário.");
                        }
                    }
                ],
                'titulo_destaque' => 'sometimes|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Atualizar título
            $destaque->titulo_destaque = $request->titulo_destaque;
            $destaque->save();

            // Sincronizar stories
            $destaque->stories()->sync($request->input('stories'));
            
            // Atualizar foto de capa se necessário
            $firstStory = $destaque->stories()->first();
            if ($firstStory) {
                $destaque->foto_destaque = $firstStory->conteudo_storyes;
                $destaque->save();
            }

            // Carregar relações atualizadas
            $destaque->load('stories.user');

            return response()->json([
                'success' => true,
                'message' => 'Destaque atualizado com sucesso!',
                'data' => [
                    'titulo_destaque' => $destaque->titulo_destaque,
                    'foto_destaque' => $this->getFullUrl($destaque->foto_destaque),
                    'stories' => $destaque->stories->map(function ($story) {
                        return $this->formatStory($story);
                    })
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao sincronizar destaque',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $destaque = Destaque::with(['stories.user'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $destaque->id,
                    'titulo_destaque' => $destaque->titulo_destaque,
                    'data_destaque' => $destaque->data_destaque,
                    'foto_destaque' => $this->getFullUrl($destaque->foto_destaque),
                    'stories' => $destaque->stories->map(function ($story) {
                        return $this->formatStory($story);
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Destaque não encontrado',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}