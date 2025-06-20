<?php

namespace App\Http\Controllers;

use App\Models\Destaque;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DestaqueController extends Controller
{
    /**
     * Exibe a lista de destaques e stories disponíveis
     */
    public function index()
    {
        try {
            $destaques = Destaque::with(['user', 'story'])
                ->orderBy('data_destaque', 'desc')
                ->get();

            $stories = Story::whereNotIn('id_story', Destaque::pluck('id_story'))
                ->get();

            return response()->json([
                'destaques' => $destaques,
                'stories' => $stories
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao carregar destaques',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Adiciona um novo destaque
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_story' => 'required|exists:stories,id_story',
            'foto_destaque' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Verifica se o story já foi destacado
        $jaDestacado = Destaque::where('id_story', $request->id_story)->exists();
        
        if ($jaDestacado) {
            return back()->with('error', 'Este story já foi destacado!');
        }

        $destaque = new Destaque();
        $destaque->id_user = Auth::id();
        $destaque->id_story = $request->id_story;
        $destaque->data_destaque = now();

        // Upload da foto de destaque se fornecida
        if ($request->hasFile('foto_destaque')) {
            $path = $request->file('foto_destaque')->store('destaques', 'public');
            $destaque->foto_destaque = $path;
        }

        $destaque->save();

        return back()->with('success', 'Story destacado com sucesso!');
    }

    /**
     * Remove um destaque
     */
    public function destroy($id)
    {
        $destaque = Destaque::findOrFail($id);
        
        // Verifica se o usuário tem permissão para remover (opcional)
        if (Auth::id() !== $destaque->id_user && !Auth::user()->isAdmin()) {
            return back()->with('error', 'Você não tem permissão para remover este destaque!');
        }

        // Remove a foto se existir
        if ($destaque->foto_destaque && Storage::exists('public/' . $destaque->foto_destaque)) {
            Storage::delete('public/' . $destaque->foto_destaque);
        }

        $destaque->delete();

        return back()->with('success', 'Destaque removido com sucesso!');
    }
}