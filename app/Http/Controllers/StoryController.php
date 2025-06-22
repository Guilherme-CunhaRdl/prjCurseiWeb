<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StoryController extends Controller
{
    /**
     * Exibe todos os stories ativos
     */
    public function index(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Range');
        header('Access-Control-Expose-Headers: Content-Length, Content-Range');
    
        Story::where('status_storyes', true)
            ->where('data_inicio', '<', Carbon::now()->subHours(24))
            ->update(['status_storyes' => false]);
    
        $stories = Story::with('user')
            ->where('status_storyes', true)
            ->orderBy('data_inicio', 'desc')
            ->get()
            ->map(function ($story) {
           
                $extension = pathinfo($story->conteudo_storyes, PATHINFO_EXTENSION);
                $tipo_midia = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : 'video';
                
                return [
                    'id' => $story->id,
                    'url' => url($story->conteudo_storyes),
                    'tipo_midia' => $tipo_midia, // Garante que o tipo de mídia está definido
                    'data_inicio' => $story->data_inicio->format('Y-m-d H:i:s'),
                    'legenda' => $story->legenda,
                    'user' => [
                        'id' => $story->user->id,
                        'nome' => $story->user->nome_user,
                        'foto' => $story->user->img_user 
                            ? url('/img/user/fotoPerfil/' . $story->user->img_user) 
                            : null
                    ]
                ];
            });
    
        return response()->json([
            'success' => true,
            'data' => $stories
        ]);
    }

    /**
     * Publica um novo story
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conteudo_storyes' => 'required|file',
            'id_user' => 'required|integer|exists:tb_user,id',
            'legenda' => 'nullable|string|max:220',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('conteudo_storyes');
            $extension = strtolower($file->getClientOriginalExtension());

            $mediaType = in_array($extension, ['jpg', 'jpeg', 'png']) ? 'image' : 'video';
            $directory = 'storys/' . ($mediaType === 'image' ? 'img' : 'videos');

            $fileName = Str::random(20) . '_' . time() . '.' . $extension;
            $file->move(public_path($directory), $fileName);
            $relativePath = $directory . '/' . $fileName;

            $story = Story::create([
                'conteudo_storyes' => $relativePath,
                'data_inicio' => Carbon::now(),
                'status_storyes' => true,
                'id_user' => $request->id_user,
                'legenda' => $request->legenda,
                'tipo_midia' => $mediaType
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Story publicado com sucesso!',
                'data' => [
                    'id' => $story->id,
                    'url' => url($relativePath),
                    'tipo_midia' => $story->tipo_midia,
                    'data_inicio' => $story->data_inicio->format('Y-m-d H:i:s')
                ]
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao salvar story', ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar o story',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deleta um story por ID
     */
    public function destroy($id)
    {
        try {
            $story = Story::findOrFail($id);

            // Deleta o arquivo físico se existir
            $filePath = public_path($story->conteudo_storyes);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $story->delete();

            return response()->json([
                'success' => true,
                'message' => 'Story removido com sucesso!'
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar story', ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover story',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function toggleLike(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:tb_user,id',
        'id_story' => 'required|exists:tb_storyes,id',
    ]);

    $like = StoryLike::where('user_id', $request->id_user)
                     ->where('story_id', $request->id_story)
                     ->first();

    if ($like) {
        $like->delete();
        return response()->json(['liked' => false]);
    } else {
        StoryLike::create([
            'user_id' => $request->id_user,
            'story_id' => $request->id_story,
        ]);
        return response()->json(['liked' => true]);
    }
}

public function isLiked(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:tb_user,id',
        'id_story' => 'required|exists:tb_storyes,id',
    ]);

    $liked = StoryLike::where('user_id', $request->id_user)
                ->where('story_id', $request->id_story)
                ->exists();

    return response()->json(['liked' => $liked]);
}



}
