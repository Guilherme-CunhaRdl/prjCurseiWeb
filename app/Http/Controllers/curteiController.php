<?php

namespace App\Http\Controllers;

use App\Models\Curtei;
use App\Models\CurtidaCurtei;
use App\Models\ComentarioCurtei;
use App\Models\CurtidaComentarioCurtei;
use App\Models\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class curteiController extends Controller
{


    public function show($id)
{
    try {
        $curtei = Curtei::with(['usuario' => function($query) {
                $query->select('id', 'nome_user', 'arroba_user', 'img_user');
            }])
            ->withCount(['curtidas', 'comentarios'])
            ->findOrFail($id);

        // Verifica se o usuário atual curtiu este vídeo
        $userId = request()->input('user_id');
        $curtiu = false;
        
        if ($userId) {
            $curtiu = CurtidaCurtei::where('id_curtei', $id)
                ->where('id_user', $userId)
                ->exists();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $curtei->id,
                'video_url' => asset($curtei->caminho_curtei),
                'thumb_url' => asset($curtei->caminho_curtei_thumb),
                'legenda' => $curtei->legenda_curtei,
                'curtidas_count' => $curtei->curtidas_count,
                'comentarios_count' => $curtei->comentarios_count,
                'curtiu' => $curtiu,
                'usuario' => [
                    'id' => $curtei->usuario->id,
                    'nome' => $curtei->usuario->nome_user,
                    'foto' => $curtei->usuario->img_user 
                        ? asset('img/user/fotoPerfil/' . $curtei->usuario->img_user) 
                        : null,
                    'arroba' => $curtei->usuario->arroba_user
                ],
                'created_at' => $curtei->created_at->format('d/m/Y H:i')
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Curtei não encontrado',
            'error' => env('APP_DEBUG') ? $e->getMessage() : null
        ], 404);
    }
}   

    public function listarPorUsuario($userId)
{
    try {
        $curteis = Curtei::with(['usuario'])
            ->withCount(['curtidas', 'comentarios'])
            ->where('id_user', $userId)
            ->where('status_curtei', '1') // Apenas ativos
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'titulo' => $item->legenda_curtei,
                    'video_url' => asset($item->caminho_curtei),
                    'thumbnail_url' => asset($item->caminho_curtei_thumb),
                    'visualizacoes' => $item->visualizacoes_count ?? 0,
                    'curtidas_count' => $item->curtidas_count,
                    'comentarios_count' => $item->comentarios_count,
                    'created_at' => $item->created_at->format('d/m/Y H:i')
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $curteis
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao listar curtéis',
            'error' => env('APP_DEBUG') ? $e->getMessage() : null
        ], 500);
    }
}
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



       //PARTE DO ADM
       public function index()
       {
           try {
            $totalCurtei = Curtei::count();
            $totalCurtidas = CurtidaCurtei::count();
            $totalCompartilhamentos = Mensagem::whereNotNull('id_curtei')->count();
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
               
               // Adicione esta query para os top curteis com contagem de compartilhamentos
               $topCurteis = Curtei::with(['usuario', 'curtidas'])
                   ->withCount('curtidas')
                   ->withCount(['mensagens as compartilhamentos_count' => function($query) {
                       $query->whereNotNull('id_curtei');
                   }])
                   ->orderByDesc('curtidas_count')
                   ->limit(3)
                   ->get();
       
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
               ->with('totalCurtidas', $totalCurtidas)
               ->with('totalCompartilhamentos', $totalCompartilhamentos)
                   ->with('CurteiPorDia', $CurteiPorDia)
                   ->with('curteisInstituicao', $curteisInstituicao)
                   ->with('curteiUsers', $curteiUsers)
                   ->with('porcentagemUser', $porcentagemUser)
                   ->with('porcentagemInst', $porcentagemInst)
                   ->with('curteisDia', $curteisDia)
                   ->with('curteisNoite', $curteisNoite)
                   ->with('porcentagemNoite', $porcentagemNoite)
                   ->with('porcentagemDia', $porcentagemDia)
                   ->with('topCurteis', $topCurteis);
                   
           } catch (\Exception $e) {
               Log::error("Erro no método index do curteiController: " . $e->getMessage());
               return back()->with('error', 'Erro ao carregar estatísticas');
           }
       }
//-------------------------//

//VOU COMENTAR PRA NINGUEM SE PERDER NESSA BUDEGA
 //CRUD BASICO 
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
                'id_user' => $validated['id_user'],
                'status_curtei' => '1'
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
 
    public function mostrarVideos()
    {
        try {
            $curteis = Curtei::with(['usuario'])
                ->withCount(['curtidas', 'comentarios'])
                ->where('status_curtei', '1')
                ->latest()
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'video_url' => asset($item->caminho_curtei),
                        'thumb_url' => asset($item->caminho_curtei_thumb),
                        'legenda' => $item->legenda_curtei,
                        'curtidas_count' => $item->curtidas_count,
                        'comentarios_count' => $item->comentarios_count,
                        'usuario' => [
                            'id' => $item->usuario->id,
                            'nome' => $item->usuario->nome_user,
                            'foto' => $item->usuario->img_user 
                                ? asset('img/user/fotoPerfil/' . $item->usuario->img_user) 
                                : null,
                            'arroba' => $item->usuario->arroba_user
                        ],
                        'created_at' => $item->created_at->format('d/m/Y H:i')
                    ];
                });
    
            return response()->json(['success' => true, 'videos' => $curteis]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao listar curteis', 'error' => $e->getMessage()], 500);
        }
    }

    
    public function updateCurtei(Request $request, $id)
    {
        try {
            $curtei = Curtei::findOrFail($id);
    
            // Validação básica
            $validated = $request->validate([
                'legenda_curtei' => 'nullable|string|max:220',
                'caminho_curtei' => [
                    'nullable',
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
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:2048' // 2MB
                ]
            ]);
    
            // Atualiza legenda se enviada
            if (isset($validated['legenda_curtei'])) {
                $curtei->legenda_curtei = $validated['legenda_curtei'];
            }
    
            // Atualiza vídeo se enviado
            if ($request->hasFile('caminho_curtei')) {
                // Remove arquivo antigo se quiser (opcional)
                if (file_exists(public_path($curtei->caminho_curtei))) {
                    unlink(public_path($curtei->caminho_curtei));
                }
                $videoNome = 'video_'.$curtei->id.'_'.time().'.'.$request->file('caminho_curtei')->extension();
                $request->file('caminho_curtei')->move(public_path('curtei/video'), $videoNome);
                $curtei->caminho_curtei = 'curtei/video/'.$videoNome;
            }
    
            // Atualiza thumb se enviado
            if ($request->hasFile('caminho_curtei_thumb')) {
                if (file_exists(public_path($curtei->caminho_curtei_thumb))) {
                    unlink(public_path($curtei->caminho_curtei_thumb));
                }
                $thumbNome = 'thumb_'.$curtei->id.'_'.time().'.'.$request->file('caminho_curtei_thumb')->extension();
                $request->file('caminho_curtei_thumb')->move(public_path('curtei/thumb'), $thumbNome);
                $curtei->caminho_curtei_thumb = 'curtei/thumb/'.$thumbNome;
            }
    
            $curtei->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Curtei atualizado com sucesso',
                'curtei' => $curtei
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar curtei: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro no servidor'
            ], 500);
        }
    }
    


public function destroy($id)
{
    try {
        $curtei = Curtei::findOrFail($id);

      
        $curtei->status_curtei = '0'; 
        $curtei->save();

        return response()->json([
            'success' => true,
            'message' => 'Curtei inativado com sucesso'
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Curtei não encontrado'
        ], 404);
    } catch (\Exception $e) {
        \Log::error("Erro ao inativar curtei: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Erro ao inativar curtei',
            'error' => env('APP_DEBUG') ? $e->getMessage() : null
        ], 500);
    }
}




//-------------------------//

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
        
            DB::commit(); 
        
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