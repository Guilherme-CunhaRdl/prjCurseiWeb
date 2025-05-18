<?php

namespace App\Http\Controllers;

use App\Models\Curtei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class curteiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalCurtei = Curtei::count();
        $CurteiPorDia = DB::table('tb_curtei')
            ->selectRaw('DAYOFWEEK(created_at) as dia_semana, COUNT(*) as total')
            ->groupBy('dia_semana')
            ->orderBy('dia_semana')
            ->get();

        $curteiUsers = DB::table('tb_curtei')
            ->join('tb_user', 'tb_curtei.id_user', '=', 'tb_user.id')
            ->leftJoin('tb_instituicao', 'tb_user.id', '=', 'tb_instituicao.id_user')
            ->whereNull('tb_instituicao.id_user')
            ->count('tb_curtei.id');
        $curteisInstituicao = DB::table('tb_curtei')
            ->join('tb_user', 'tb_curtei.id_user', '=', 'tb_user.id')
            ->join('tb_instituicao', 'tb_user.id', '=', 'tb_instituicao.id_user')
            ->count('tb_curtei.id');
        
        function porcentagem($valor,$total){
            $resultado =number_format(($valor / $total) * 100,1,',','.');
            return $resultado;
        }
        $porcentagemUser = porcentagem($curteiUsers,$totalCurtei);
        $porcentagemInst = porcentagem($curteisInstituicao,$totalCurtei);

        $curteisDia = Curtei::whereRaw('HOUR(created_at) BETWEEN   6 and 18')->count();
        $curteisNoite = Curtei::whereRaw('HOUR(created_at) >= 18 OR HOUR(created_at) < 6')->count();
        $porcentagemNoite = porcentagem($curteisNoite,$totalCurtei);
        $porcentagemDia = porcentagem($curteisDia,$totalCurtei);
        
        return view('area-adm.curtei')
            ->with('totalCurtei', $totalCurtei)
            ->with('CurteiPorDia', $CurteiPorDia)
            ->with('curteisInstituicao', $curteisInstituicao)
            ->with('curteiUsers', $curteiUsers)
            ->with('porcentagemUser', $porcentagemUser)
            ->with('porcentagemInst', $porcentagemInst)
            ->with('curteisDia', $curteisDia)
            ->with('curteisNoite', $curteisNoite)
            ->with('porcentagemNoite', $porcentagemNoite)
            ->with('porcentagemDia', $porcentagemDia)
        ;
    }

    public function storeCurtei(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'caminho_curtei' => 'required|file|mimes:mp4,mov,avi|max:25600', // 25MB
            'caminho_curtei_thumb' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
            'legenda_curtei' => 'nullable|string|max:220',
            'id_user' => 'required|integer|exists:tb_user,id' 
        ]);
    
        try {
        
            if (!file_exists(public_path('curtei/video'))) {
                mkdir(public_path('curtei/video'), 0755, true);
            }
            if (!file_exists(public_path('curtei/thumb'))) {
                mkdir(public_path('curtei/thumb'), 0755, true);
            }
    
           
            $videoNome = 'video_'.$validated['id_user'].'_'.time().'.'.$request->file('caminho_curtei')->extension();
            $thumbNome = 'thumb_'.$validated['id_user'].'_'.time().'.'.$request->file('caminho_curtei_thumb')->extension();
    
       
            $request->file('caminho_curtei')->move(public_path('curtei/video'), $videoNome);
            $request->file('caminho_curtei_thumb')->move(public_path('curtei/thumb'), $thumbNome);
    
          
            $curtei = Curtei::create([
                'caminho_curtei' => 'curtei/video/'.$videoNome,
                'caminho_curtei_thumb' => 'curtei/thumb/'.$thumbNome,
                'legenda_curtei' => $validated['legenda_curtei'],
                'id_user' => $validated['id_user'] 
            ]);
    
            return response()->json([
                'success' => true,
                'video' => $curtei,
                'video_url' => asset('curtei/video/'.$videoNome),
                'thumb_url' => asset('curtei/thumb/'.$thumbNome)
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro no servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function mostrarVideos()
    {
        try {
         
            $videos = Curtei::with(['usuario'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($video) {
                    return [
                        'id' => $video->id,
                        'video_url' => asset($video->caminho_curtei),
                        'thumb_url' => asset($video->caminho_curtei_thumb),
                        'legenda' => $video->legenda_curtei,
                        'usuario' => [
                            'id' => $video->usuario->id,
                            'nome' => $video->usuario->nome_user,
                            'foto' => $video->usuario->img_user ? asset($video->usuario->img_user) : null,
                            'arroba' => $video->usuario->arroba_user
                        ],
                        'data_postagem' => $video->created_at->format('d/m/Y H:i')
                    ];
                });
    
            return response()->json([
                'success' => true,
                'videos' => $videos
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar vídeos',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
