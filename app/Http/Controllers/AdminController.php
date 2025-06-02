<?php

namespace App\Http\Controllers;

use App\Models\Seguidores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Adm;
use App\Models\Instituicao;
use App\Models\Repostar;
use App\Models\Post;
use App\Models\User;
use App\Models\Curtida;
use App\Models\Curtei;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;




class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // aumento de usuarios
        $inicioMesAtual = Carbon::now()->startOfMonth();
        $inicioMesAnterior = Carbon::now()->subMonth()->startOfMonth();
        $usuariosMesAtual = User::where('created_at', '>=', $inicioMesAtual)->count();
        $fimMesAnterior = Carbon::now()->subMonth()->endOfMonth();

        $usuariosMesAnterior = User::whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])->count();
        if ($usuariosMesAnterior > 0) {
            $aumentoUser = (($usuariosMesAtual - $usuariosMesAnterior) / $usuariosMesAnterior) * 100;
        } else {
            $aumentoUser = $usuariosMesAtual > 0 ? 100 : 0;
        }
        // aumento de instituicoes
        $instMesAtual = Instituicao::where('created_at', '>=', $inicioMesAtual)->count();
        $fimMesAnterior = Carbon::now()->subMonth()->endOfMonth();

        $instMesAnterior = Instituicao::whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])->count();
        if ($instMesAnterior > 0) {
            $aumentoInst = (($instMesAtual - $instMesAnterior) / $instMesAnterior) * 100;
        } else {
            $aumentoInst = $instMesAtual > 0 ? 100 : 0;
        }
        // aumento de posts
        $postsMesAtual = Post::where('created_at', '>=', $inicioMesAtual)->count();
        $fimMesAnterior = Carbon::now()->subMonth()->endOfMonth();

        $postsMesAnterior = Post::whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])->count();
        if ($postsMesAnterior > 0) {
            $aumentoPosts = (($postsMesAtual - $postsMesAnterior) / $postsMesAnterior) * 100;
        } else {
            $aumentoPosts = $postsMesAtual > 0 ? 100 : 0;
        }
        // total
        $usuariosPorMes = DB::table('tb_user')
            ->selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', 2025)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('mes')
            ->get();

        $instituicoesPorMes = DB::table('tb_instituicao')
            ->selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', 2025)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('mes')
            ->get();
        $usuarios = User::where('status_user', '1')->count();
        $Instituicoes = DB::table('tb_instituicao')
            ->join('tb_user', 'tb_instituicao.id_user', '=', 'tb_user.id')
            ->where('tb_user.status_user', 1)
            ->count('tb_instituicao.id_user');
        $posts = Post::where('status_post', '1')->count();
        return view('area-adm.dashboard')
            ->with('usuarios', $usuarios)
            ->with('instituicoes', $Instituicoes)
            ->with('posts', $posts)
            ->with('aumentoUser', $aumentoUser)
            ->with('aumentoInst', $aumentoInst)
            ->with('aumentoPosts', $aumentoPosts)
            ->with('usuariosPorMes', $usuariosPorMes)
            ->with('instituicoesPorMes', value: $instituicoesPorMes);
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
    public function store()
    {
        $adm = new Adm();
        $adm->token_admin = 111;
        $adm->email_admin = "eduardo";
        $adm->email_admin = "eduardo";
        $adm->nome_admin = "eduardo";
        $adm->password = Hash::make("123"); // Criptografando a senha com bcrypt
        $adm->save();
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
    public function edit()
    {
        $adm = Adm::limit(1)->select('nome_admin', 'email_admin')->get();

        return view('area-adm.configuracoes')->with('adm', $adm);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $adm = adm::findOrFail($id);
        $adm->nome_admin = $request->input('nome');
        $adm->email_admin = $request->input('email');
        $adm->password = Hash::make($request->input('senha'));
        $adm->save();
        return redirect('/curseiAdm/configuracoes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function logar(Request $request)
    {
        $login = [
            'nome_admin' => $request->input('nome_admin'),
            'password' => $request->input('senha_admin')  // Mapeando 'senha_admin' para 'password'
        ];
        if (Auth::guard('adm')->attempt($login)) {
            $request->session()->regenerate();
            return redirect()->intended('/curseiAdm');
        }
        return back()->withErrors([
            'nome_admin' => 'senha ou usuario invalidos',

        ]);
    }
    public function deslogar(Request $request): RedirectResponse
    {
        Auth::guard('adm')->logout();
        $request->session()->invalidate(); // Invalida a sessão atual
        $request->session()->regenerateToken(); // Gera novo token CSRF

        return redirect('curseiAdm/login');
    }
    public function nome()
    {
        $nome = Adm::pluck('nome_admin');
        return response()->json($nome);
    }
  
    public function instituicoesAdm()
    {
        
        $todasInstituicoes = User::whereHas('instituicao') // Só usuários que são instituições
            ->withCount([
                'posts as total_curtidas' => function ($query) {
                    $query->join('tb_curtida', 'tb_post.id', '=', 'tb_curtida.id_post');
                },
                'seguidor as total_seguidores' => function ($query) {
                    $query->where('status_seguidores', 1);
                },
            ])
            ->with('instituicao') 
            ->get();

        return view('area-adm.instituicoes', compact('todasInstituicoes'));
    }




    public function selectAllPostAdm()
    {

        $posts = Post::with(['usuario', 'curtidas'])
        ->withCount(['curtidas', 'comentario'])
        ->get();

        return view('area-adm.TodosPost', compact('posts'));
    }

    public function selectAllRellsAdm()
    {

        $Curtei = Curtei::with(['usuario', 'curtidas'])->withCount('curtidas')->get();
        return view('area-adm.TodosRells', compact('Curtei'));
    }



    public function DashDoUserAdm($userId)
    {
        $usuario = User::withCount(['seguidor', 'seguindo'])->find($userId);
    
        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuário não encontrado.');
        }
    
     
        $numeroPosts = Post::where('id_user', $userId)->count();
        $numeroCurtidas = Curtida::whereIn('id_post', Post::where('id_user', $userId)->pluck('id'))->count();
        $quantidadeCurtei = Curtei::where('id_user', $userId)->count();
    
      
        $ultimosSeguidores = Seguidores::with(['usuarioSeguidor' => function($query) {
            $query->select('id', 'nome_user', 'img_user', 'arroba_user');
        }])
        ->where('id_user_seguido', $userId)
        ->where('status_seguidores', true)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
   
        $seguindo = Seguidores::with(['usuarioSeguido' => function($query) {
            $query->select('id', 'nome_user', 'img_user', 'arroba_user');
        }])
        ->where('id_user_seguidor', $userId)
        ->where('status_seguidores', true)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
        return view('area-adm.dashboardUser', [
            'usuario' => $usuario,
            'numeroPosts' => $numeroPosts,
            'numeroCurtidas' => $numeroCurtidas,
            'numeroSeguidores' => $usuario->seguidor_count, 
            'numeroSeguindo' => $usuario->seguindo_count,
            'ultimosSeguidores' => $ultimosSeguidores,
            'seguindo' => $seguindo,
            'quantidadeCurtei' => $quantidadeCurtei
        ]);
    }

    public function DashDaInstAdm($userId)
    {
        $usuario = User::find($userId);
        $instituicao = Instituicao::where('id_user', $userId)->first();

        $numeroPosts = Post::where('id_user', $userId)->count();
        $numeroCurtidas = Curtida::whereIn('id_post', Post::where('id_user', $userId)->pluck('id'))->count();
        $numeroSeguidores = Seguidores::where('id_user_seguido', $userId)->count();
        $numeroSeguindo = Seguidores::where('id_user_seguidor', $userId)->count();
        $quantidadeCurtei = Curtei::where('id_user', $userId)->count();
        $quantidadeReposts = Repostar::where('id_user', $userId)->count();

        return view('area-adm.dashboardInstituicao', compact(
            'usuario',
            'instituicao',
            'numeroPosts',
            'numeroCurtidas',
            'numeroSeguidores',
            'numeroSeguindo',
            'quantidadeCurtei',
             'quantidadeReposts'
        ));
    }

    public function atualizar(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:tb_user,email_user,'.$id,
            'usuario' => 'required|string|max:255|unique:tb_user,arroba_user,'.$id,
            'senha' => 'nullable|string|min:6', // Senha opcional
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $usuario = User::findOrFail($id);
    
       
        if ($request->hasFile('foto')) {
   
            if ($usuario->img_user && file_exists(public_path('img/user/fotoPerfil/'.$usuario->img_user))) {
                unlink(public_path('img/user/fotoPerfil/'.$usuario->img_user));
            }
            
            $nomeImagem = 'perfil_'.time().'.'.$request->foto->extension();
            $request->foto->move(public_path('img/user/fotoPerfil'), $nomeImagem);
            $usuario->img_user = $nomeImagem;
        }
    
     
        if ($request->hasFile('banner')) {
       
            if ($usuario->banner_user && file_exists(public_path('img/user/bannerPerfil/'.$usuario->banner_user))) {
                unlink(public_path('img/user/bannerPerfil/'.$usuario->banner_user));
            }
            
            $nomeBanner = 'banner_'.time().'.'.$request->banner->extension();
            $request->banner->move(public_path('img/user/bannerPerfil'), $nomeBanner);
            $usuario->banner_user = $nomeBanner;
        }
    
   
        $usuario->nome_user = $request->nome;
        $usuario->arroba_user = $request->usuario;
        $usuario->email_user = $request->email;
        
     
        if ($request->filled('senha')) {
            $usuario->senha_user = Hash::make($request->senha);
        }
    
        $usuario->save();
    
        return redirect()->route('usuario')->with('success', 'Usuário atualizado com sucesso!');
    }



    public function atualizarInst(Request $request, $id)
    {
 
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:tb_user,email_user,'.$id,
            'usuario' => 'required|string|max:255|unique:tb_user,arroba_user,'.$id,
            'senha' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
    
        try {
            $usuario = User::findOrFail($id);
            if ($request->hasFile('foto')) {
                if ($usuario->img_user && file_exists(public_path('img/user/fotoPerfil/'.$usuario->img_user))) {
                    unlink(public_path('img/user/fotoPerfil/'.$usuario->img_user));
                }
                $nomeImagem = 'perfil_'.$id.'_'.time().'.'.$request->foto->extension();
                $request->foto->move(public_path('img/user/fotoPerfil'), $nomeImagem);
                

                $usuario->img_user = $nomeImagem;
            }
    

            if ($request->hasFile('banner')) {
                if ($usuario->banner_user && file_exists(public_path('img/user/bannerPerfil/'.$usuario->banner_user))) {
                    unlink(public_path('img/user/bannerPerfil/'.$usuario->banner_user));
                }
                $nomeBanner = 'banner_'.$id.'_'.time().'.'.$request->banner->extension();
                $request->banner->move(public_path('img/user/bannerPerfil'), $nomeBanner);
                $usuario->banner_user = $nomeBanner;
            }
    
  
            $usuario->nome_user = $validated['nome'];
            $usuario->email_user = $validated['email'];
            $usuario->arroba_user = $validated['usuario'];
    
     
            if (!empty($validated['senha'])) {
                $usuario->senha_user = Hash::make($validated['senha']);
            }
    
            $usuario->save();
    
            return redirect()->route('instituicao')->with('success', 'Perfil atualizado com sucesso!');
    
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar perfil: '.$e->getMessage())
                ->withInput();
        }
    }

    
    


    public function atualizarInstDados(Request $request,$idUsuario){

        $request-> validate([
            'cep' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',

        ]);
      
        $instituicao = Instituicao::where('id_user', $idUsuario)->firstOrFail();
        
        $instituicao->cep_instituicao= $request->input('cep');
        $instituicao->logradouro_instituicao= $request->input('endereco');
        $instituicao->num_logradouro_instituicao= $request->input('numero');
        $instituicao->bairro_instituicao= $request->input('bairro');
        $instituicao->estado_instituicao= $request->input('estado');
        $instituicao->cidade_instituicao= $request->input('cidade');

  
        $instituicao->save();

        return redirect()->route('instituicao');
    }
    public function verificarInst($id,$acao){
        if($acao == "aprovar"){
         $instituicao = Instituicao::where('id_user', $id)->firstOrFail();
         $instituicao->verificado_instituicao = 1;
         $instituicao->save();
         return redirect('/curseiAdm/dashInstituicaoAdm/'.$id);
        }elseif( $acao == "recusar"){
         Instituicao::where('id_user', $id)->delete();
         return redirect( '/curseiAdm/instituicao');
 
     }
     }
}
