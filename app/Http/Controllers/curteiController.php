<?php

namespace App\Http\Controllers;

use App\Models\Curtei;
use App\Models\CurtidaCurtei;
use App\Models\ComentarioCurtei;
use App\Models\CurtidaComentarioCurtei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class curteiController extends Controller
{
    public function curtir($id)
    {
        try {
            $userId = request()->input('id_user');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID do usuário não fornecido'
                ], 400);
            }

            // Verifica se já curtiu
            $existingLike = CurtidaCurtei::where('id_user', $userId)
                                ->where('id_curtei', $id)
                                ->first();
        
            if ($existingLike) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você já curtiu este vídeo'
                ], 400);
            }
        
            DB::beginTransaction();
            
            try {
                CurtidaCurtei::create([
                    'id_user' => $userId,
                    'id_curtei' => $id
                ]);
                
                Curtei::where('id', $id)->increment('curtidas_count');
                
                DB::commit();
                
                $curtei = Curtei::find($id);
            
                return response()->json([
                    'success' => true,
                    'curtidas_count' => $curtei->curtidas_count
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Erro ao curtir vídeo: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao processar curtida',
                    'error' => $e->getMessage()
                ], 500);
            }
        
        } catch (\Exception $e) {
            Log::error("Erro geral em curtir: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro no servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
     
    public function descurtir($id)
    {
        try {
            $userId = request()->input('id_user');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID do usuário não fornecido'
                ], 400);
            }
            
            DB::beginTransaction();
            
            try {
                $deleted = CurtidaCurtei::where('id_user', $userId)
                           ->where('id_curtei', $id)
                           ->delete();
                           
                if ($deleted) {
                    Curtei::where('id', $id)->decrement('curtidas_count');
                }
                
                DB::commit();
                
                $curtei = Curtei::find($id);
            
                return response()->json([
                    'success' => true,
                    'curtidas_count' => $curtei->curtidas_count
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Erro ao descurtir vídeo: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao processar descurtida',
                    'error' => $e->getMessage()
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error("Erro geral em descurtir: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro no servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function curtidasPorUsuario($userId)
    {
        try {
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID do usuário não fornecido'
                ], 400);
            }

            $curtidas = CurtidaCurtei::where('id_user', $userId)
                ->select('id_curtei')
                ->get()
                ->map(function($item) {
                    return ['id_curtei' => $item->id_curtei];
                });

            return response()->json([
                'success' => true,
                'curtidas' => $curtidas
            ]);
            
        } catch (\Exception $e) {
            Log::error("Erro ao buscar curtidas por usuário: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar curtidas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
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
                $resultado = ($total != 0) 
                ? number_format(($valor / $total) * 100, 1, ',', '.') 
                : '0,0';
                return $resultado;
            }
            $porcentagemUser = porcentagem($curteiUsers,$totalCurtei);
            $porcentagemInst = porcentagem($curteisInstituicao,$totalCurtei);

            $curteisDia = Curtei::whereRaw('HOUR(created_at) BETWEEN 6 and 18')->count();
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
                ->with('porcentagemDia', $porcentagemDia);
                
        } catch (\Exception $e) {
            Log::error("Erro no método index do curteiController: " . $e->getMessage());
            return back()->with('error', 'Erro ao carregar estatísticas');
        }
    }

    public function storeCurtei(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200);
        }

        try {
            Log::info('Dados recebidos:', $request->all());
            Log::info('Arquivos recebidos:', $request->allFiles());
            
            // Validação dos dados
            $validated = $request->validate([
                'caminho_curtei' => [
                    'required',
                    'file',
                    function ($attribute, $value, $fail) {
                        $allowed = ['video/mp4', 'video/quicktime', 'video/x-msvideo'];
                        if (!in_array($value->getMimeType(), $allowed)) {
                            $fail("O vídeo deve ser do tipo: mp4, mov, avi.");
                        }
                    },
                    'max:25600' // 25MB
                ],
                'caminho_curtei_thumb' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:2048' // 2MB
                ],
                'legenda_curtei' => 'nullable|string|max:220',
                'id_user' => 'required|integer|exists:tb_user,id' 
            ]);
        
            // Cria os diretórios se não existirem
            if (!file_exists(public_path('curtei/video'))) {
                if (!mkdir(public_path('curtei/video'), 0755, true)) {
                    throw new \Exception("Falha ao criar diretório para vídeos");
                }
            }
            
            if (!file_exists(public_path('curtei/thumb'))) {
                if (!mkdir(public_path('curtei/thumb'), 0755, true)) {
                    throw new \Exception("Falha ao criar diretório para thumbnails");
                }
            }
        
            // Gera nomes únicos para os arquivos
            $videoNome = 'video_'.$validated['id_user'].'_'.time().'.'.$request->file('caminho_curtei')->extension();
            $thumbNome = 'thumb_'.$validated['id_user'].'_'.time().'.'.$request->file('caminho_curtei_thumb')->extension();
        
            // Move os arquivos
            $videoMoved = $request->file('caminho_curtei')->move(public_path('curtei/video'), $videoNome);
            $thumbMoved = $request->file('caminho_curtei_thumb')->move(public_path('curtei/thumb'), $thumbNome);
            
            if (!$videoMoved || !$thumbMoved) {
                throw new \Exception("Falha ao mover arquivos para o servidor");
            }
        
            // Cria o registro no banco de dados
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
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Erro de validação em storeCurtei: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error("Erro em storeCurtei: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro no servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // Método para mostrar vídeos com informações do usuário e contagem de curtidas
    public function mostrarVideos()
    {
        try {
            $videos = Curtei::with(['usuario'])
                ->withCount('curtidas')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($video) {
                    return [
                        'id' => $video->id,
                        'video_url' => asset($video->caminho_curtei),
                        'thumb_url' => asset($video->caminho_curtei_thumb),
                        'legenda' => $video->legenda_curtei,
                        'curtidas_count' => $video->curtidas_count,
                        'usuario' => [
                            'id' => $video->usuario->id,
                            'nome' => $video->usuario->nome_user,
                            'foto' => $video->usuario->img_user ? asset('img/user/fotoPerfil/'.$video->usuario->img_user) : null,
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
            Log::error("Erro em mostrarVideos: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar vídeos',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function comentarios(Request $request)
    {
        $request->validate([
            'id_curtei' => 'required|exists:tb_curtei,id',
            'id_user' => 'nullable|exists:tb_user,id'
        ]);

        try {
            $comentarios = ComentarioCurtei::with(['usuario' => function($q) {
                    $q->select('id', 'nome_user', 'arroba_user', 'img_user');
                }])
                ->withCount('curtidas')
                ->where('id_curtei', $request->id_curtei)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($comentario) use ($request) {
                    $curtiu = false;
                    if ($request->id_user) {
                        $curtiu = CurtidaComentarioCurtei::where('id_comentario', $comentario->id)
                            ->where('id_user', $request->id_user)
                            ->exists();
                    }
                    
                    return [
                        'id' => $comentario->id,
                        'comentario' => $comentario->comentario,
                        'created_at' => $comentario->created_at,
                        'curtidas_count' => $comentario->curtidas_count,
                        'curtiu' => $curtiu,
                        'usuario' => $comentario->usuario
                    ];
                });

            return response()->json([
                'success' => true,
                'comentarios' => $comentarios
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar comentários'
            ], 500);
        }
    }

    /**
     * Adicionar comentário
     */
    public function adicionarComentario(Request $request)
    {
        $validated = $request->validate([
            'id_curtei' => 'required|exists:tb_curtei,id',
            'id_user' => 'required|exists:tb_user,id',
            'comentario' => 'required|string|max:500|min:1'
        ]);
    
        // Remove espaços extras e verifica se ficou vazio
        $comentarioLimpo = trim($validated['comentario']);
        if (empty($comentarioLimpo)) {
            return response()->json([
                'success' => false,
                'message' => 'O comentário não pode estar vazio'
            ], 422);
        }




        
    
        DB::beginTransaction();
        
    try {
        $comentario = ComentarioCurtei::create([
            'id_curtei' => $validated['id_curtei'],
            'id_user' => $validated['id_user'],
            'comentario' => $comentarioLimpo
        ]);

        // Carrega os dados do usuário
        $comentario->load(['usuario' => function($query) {
            $query->select('id', 'nome_user', 'arroba_user', 'img_user');
        }]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $comentario->id,
                'comentario' => $comentario->comentario,
                'created_at' => $comentario->created_at,
                'usuario' => [
                    'arroba_user' => $comentario->usuario->arroba_user,
                    'img_user' => $comentario->usuario->img_user
                ]
            ]
        ]);

    } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao adicionar comentário: '.$e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao adicionar comentário',
                'debug' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
    /**
     * Curtir/Descurtir comentário
     */
    public function curtirComentario(Request $request)
    {
        $request->validate([
            'id_comentario' => 'required|exists:comentario_curteis,id',
            'id_user' => 'required|exists:tb_user,id',
            'acao' => 'required|in:curtir,descurtir'
        ]);

        try {
            DB::beginTransaction();

            if ($request->acao === 'curtir') {
                CurtidaComentarioCurtei::firstOrCreate([
                    'id_comentario' => $request->id_comentario,
                    'id_user' => $request->id_user
                ]);
            } else {
                CurtidaComentarioCurtei::where([
                    'id_comentario' => $request->id_comentario,
                    'id_user' => $request->id_user
                ])->delete();
            }

            $curtidasCount = CurtidaComentarioCurtei::where('id_comentario', $request->id_comentario)->count();

            DB::commit();

            return response()->json([
                'success' => true,
                'curtidas_count' => $curtidasCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar curtida'
            ], 500);
        }
    }
}