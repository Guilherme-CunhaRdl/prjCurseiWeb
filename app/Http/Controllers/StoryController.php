<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StoryController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conteudo_storyes' => 'required|file',
            'id_user' => 'required|integer|exists:tb_user,id'
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
            $directory = "storys/" . ($mediaType === 'image' ? 'img' : 'videos');
            $fileName = Str::random(20) . '_' . time() . '.' . $extension;

            $file->move(public_path($directory), $fileName);
            $relativePath = $directory . '/' . $fileName;

            $thumbnailPath = null;

            // Se for vídeo, gerar thumbnail
            if ($mediaType === 'video') {
                $thumbnailDir = 'storys/thumbnails';
                if (!file_exists(public_path($thumbnailDir))) {
                    mkdir(public_path($thumbnailDir), 0755, true);
                }

                $thumbnailName = Str::random(20) . '_thumb.jpg';
                $fullVideoPath = public_path($relativePath);
                $fullThumbnailPath = public_path($thumbnailDir . '/' . $thumbnailName);

                // Gerar thumbnail usando FFmpeg
                $cmd = "ffmpeg -i \"$fullVideoPath\" -ss 00:00:01.000 -vframes 1 \"$fullThumbnailPath\"";
                exec($cmd);

                $thumbnailPath = file_exists($fullThumbnailPath) ? $thumbnailDir . '/' . $thumbnailName : null;
            }

            // Criar story
            $story = Story::create([
                'conteudo_storyes' => $relativePath,
                'data_inicio' => Carbon::now(),
                'status_storyes' => true,
                'id_user' => $request->id_user,
                'tipo_midia' => $mediaType,
                'thumbnail' => $thumbnailPath // NOVO campo
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Story publicado com sucesso!',
                'data' => [
                    'id' => $story->id,
                    'url' => url($relativePath),
                    'thumbnail' => $thumbnailPath ? url($thumbnailPath) : null,
                    'tipo_midia' => $story->tipo_midia,
                    'data_inicio' => $story->data_inicio->format('Y-m-d H:i:s')
                ]
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Erro ao salvar story no banco', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar o story',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function index(Request $request)
    {
        $stories = Story::with('user')
            ->where('status_storyes', true)
            ->orderBy('data_inicio', 'desc')
            ->get()
            ->map(function ($story) {
                return [
                    'id' => $story->id,
                    'url' => url($story->conteudo_storyes),
                    'tipo_midia' => $story->tipo_midia,
                    'data_inicio' => $story->data_inicio->format('Y-m-d H:i:s'),
                    'user' => [
                        'id' => $story->user->id,
                        'nome' => $story->user->nome_user,

                        'foto' => $story->user->img_user ? url('/img/user/fotoPerfil/' . $story->user->img_user) : null
                    ]
                ];
            });
    
        return response()->json([
            'success' => true,
            'data' => $stories
        ]);
    }
    public function destroy($id)
    {
        try {
            $story = Story::findOrFail($id);
            
            // Deletar arquivo físico
            $filePath = public_path($story->conteudo_storyes);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Deletar registro
            $story->delete();

            return response()->json([
                'success' => true,
                'message' => 'Story removido com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover story',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}