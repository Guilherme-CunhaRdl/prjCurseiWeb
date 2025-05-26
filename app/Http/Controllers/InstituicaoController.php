<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Seguidores;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash; // coloca isso no início do seu arquivo

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
//carbon é um modelo de data do laravel, usei ele pra criar as datas
use Carbon\Carbon;

//to chamando o carbon e definindo como estilo brasileiro
Carbon::setLocale('pt-BR');

class InstituicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $instituicaoId = session('instituicao_id'); // Recupera o ID da instituição logada


        $instituicao = User::where('id', $instituicaoId)->first(); 

        //criei um array pra guardar cada cont e seu respectivo mes
        $seguidoresPorMes = [];

        //array com os meses
        $nomeMeses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Marco',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];
        //percorrendo o array de nomes e guardando os conts
        foreach($nomeMeses as $numero => $nome){
            $seguidoresPorMes[$nome] = Seguidores::whereMonth('created_at' , $numero)->count();
        }
        //criando um array de curtidas pra guardas seus meses e seus respectivos valores
        $curtidasPorMes = [];

        foreach($nomeMeses as $numero => $nome){
            $curtidasPorMes[$nome] = DB::table('tb_curtida')
            ->join('tb_post', 'tb_curtida.id_post' , '=', 'tb_post.id')
            ->join('tb_user', 'tb_post.id_user', '=','tb_user.id')
            ->where('tb_user.id', $instituicaoId)
            ->whereMonth('tb_curtida.created_at', $numero)
            ->count('tb_post.id');
        }
        //criando datas de inicio e de fim(data fim é 5 meses atrás)
        $dataFim = Carbon::now();
        $dataInicio = Carbon::now()->subMonths(5)->startOfMonth();

       

        //criando um array pra guardar os 6 meses
        $ultimos6Meses = [];

        for($i = 5; $i >= 0; $i--){
            $mes = Carbon::now()->subMonths($i);
            $nomeMes = $mes->isoFormat('MMMM');
            $ultimos6Meses[] = ucfirst($nomeMes); 
        }

        //aqui to só fazendo um bagui pra traduzir
        $traducaoMeses = [
            'January' => 'Janeiro',
            'February' => 'Fevereiro',
            'March' => 'Março',
            'April' => 'Abril',
            'May' => 'Maio',
            'June' => 'Junho',
            'July' => 'Julho',
            'August' => 'Agosto',
            'September' => 'Setembro',
            'October' => 'Outubro',
            'November' => 'Novembro',
            'December' => 'Dezembro'
        ];
        //fazendo um select dos ultimos 6 meses em uma query só
            $seguidoresDosUltimos6Meses = DB::table('tb_seguidores')
            ->selectRaw('MONTHNAME(created_at) as mes, Count(*) as total')
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->groupBy(DB::raw('MONTHNAME(created_at)'))
            ->orderByRaw('MONTH(created_at)')
            ->pluck('total', 'mes');

            //aqui to criando uma tradução pra os ultimos 6 meses
            $seguidoresTraduzidos = [];
            foreach ($seguidoresDosUltimos6Meses as $mesIngles => $total) {
                $mesPt = $traducaoMeses[$mesIngles] ?? $mesIngles;
                $seguidoresTraduzidos[$mesPt] = $total;
            }
        

        //selecionando o ultimo post editado    
        $ultimoPostEditado = DB::table('tb_post')
        ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
        ->where('tb_user.id', $instituicaoId)
        ->orderBy('tb_post.updated_at', 'desc')
        ->limit(1)
        ->select('tb_post.*')
        ->get();

        //selecionando planejados
        $planejados = DB::table('tb_planejamento')
        ->join('tb_post', 'tb_planejamento.id_post' , '=', 'tb_post.id')
        ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
        ->where('tb_user.id', $instituicaoId)
        ->orderBy('tb_planejamento.created_at', 'desc')
        ->limit(2)
        ->select('tb_planejamento.nome_planejamento', 'tb_planejamento.data_inicio_planejamento', 'tb_planejamento.data_fim_planejamento', 'tb_planejamento.status_planejamento','tb_post.descricao_post', 'tb_post.conteudo_post')
        ->get();

        //retornando tudo
        return view('instituicao.dashboard.index', ['listaSeguidores' => $seguidoresPorMes,
                                                    'listaCurtidas' => $curtidasPorMes,
                                                    'seguidores6Meses' => $seguidoresTraduzidos,
                                                    'nomeUltimos6Meses' => $ultimos6Meses,
                                                    'ultimoPost' => $ultimoPostEditado,
                                                    'planejados' => $planejados,
                                                    'instituicao' => $instituicao
                                                ]);
    }

    public function loginInstituicao()
    {
        return view('instituicao.login.index');
    }

    public function analiseConteudoInstituicao()
    {

        $instituicaoId = session('instituicao_id'); // Recupera o ID da instituição logada


        $instituicao = User::where('id', $instituicaoId)->first(); 
        // Verifica se a instituição está logada
        // Buscar os posts mais curtidos
        $postsMaisCurtidos = DB::table('tb_post')
            ->join('tb_curtida', 'tb_post.id', '=', 'tb_curtida.id_post')
            ->select('tb_post.titulo_post','tb_post.conteudo_post', DB::raw('COUNT(tb_curtida.id) as total_curtidas'))
            ->where('tb_post.id_user', $instituicaoId) // Substitui o ID fixo
            ->groupBy('tb_post.id', 'tb_post.titulo_post', 'tb_post.conteudo_post')
            ->orderBy('total_curtidas', 'desc')
            ->limit(5) // Limitar aos 5 posts mais curtidos
            ->get();

        $ultimoSeguidor = DB::table('tb_seguidores')
            ->join('tb_user', 'tb_seguidores.id_user_seguidor', '=', 'tb_user.id')
            ->where('tb_seguidores.id_user_seguido', $instituicaoId) // Substitui o ID fixo
            ->orderBy('tb_seguidores.created_at', 'desc')
            ->limit(1)
            ->select('tb_user.nome_user as nameUser', 'tb_user.img_user as imgUser') // seleciona o nome e imagem do seguidor
            ->get();

        $postComMaisCurtidas = DB::table('tb_post')
            ->join('tb_curtida', 'tb_post.id', '=', 'tb_curtida.id_post')
            ->select('tb_post.titulo_post', DB::raw('COUNT(tb_curtida.id) as total_curtidas'))
            ->where('tb_post.id_user', $instituicaoId) // Substitui o ID fixo
            ->groupBy('tb_post.id', 'tb_post.titulo_post')
            ->orderBy('total_curtidas', 'desc')
            ->limit(1)
            ->get();
        // Retornar a view com os dados
        return view('instituicao.analise-conteudo.index', [
            'instituicao' => $instituicao,
            'postsMaisCurtidos' => $postsMaisCurtidos,
            'ultimoSeguidor' => $ultimoSeguidor,
            'postComMaisCurtidas' => $postComMaisCurtidas
        ]);
    }

    public function fazerLoginInstituicao(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required'
        ]);
    
        $instituicao = DB::table('tb_user')
            ->join('tb_instituicao', 'tb_user.id', '=', 'tb_instituicao.id_user')
            ->where('tb_user.email_user', $request->email)
            ->where('tb_instituicao.verificado_instituicao', true)
            ->first();

        if ($instituicao && Hash::check($request->senha, $instituicao->senha_user)) {
            // Se a senha estiver correta
            // Autenticar o usuário
            session(['instituicao_id' => $instituicao->id_user]);
    
            // Redirecionar para a página inicial da instituição
            return redirect()->route('dashboard.index')
                ->with('success', 'Login realizado com sucesso!');
        } else {
            return redirect()->route('login')->withErrors('Email ou senha inválidos.');
        }

    }

    public function logoutInstituicao()
    {
        session()->forget('instituicao_id'); // Remove o ID
        session()->invalidate();             // Invalida a sessão atual
        session()->regenerateToken();  
        return redirect()->route('login');
    }

    public function bibliotecaMidiaIndex(){


        $instituicaoId = session('instituicao_id'); // Recupera o ID da instituição logada


        $instituicao = User::where('id', $instituicaoId)->first(); 

        $posts = DB::table('tb_post')
    ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
    ->leftJoin('tb_curtida', 'tb_curtida.id_post', '=', 'tb_post.id')
    ->select(
        'tb_post.id as post_id',
        'tb_post.titulo_post',
        'tb_post.descricao_post',
        'tb_post.conteudo_post',
        'tb_post.status_post',
        'tb_post.created_at',
        DB::raw('COUNT(tb_curtida.id) as total_curtidas')
    )
    ->where('tb_user.id', $instituicaoId)
    ->groupBy(
        'tb_post.id',
        'tb_post.titulo_post',
        'tb_post.descricao_post',
        'tb_post.conteudo_post',
        'tb_post.status_post',
        'tb_post.created_at'
    )
    ->get();


        return view('instituicao.biblioteca-midias.index', ['posts' => $posts,  'instituicao' => $instituicao]);
    }

    public function personalizacaoIndex(){


        $instituicaoId = session('instituicao_id'); // Recupera o ID da instituição logada


        $instituicao = User::where('id', $instituicaoId)->first(); 
        
        $posts = DB::table('tb_post')
        ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
        ->leftJoin('tb_curtida', 'tb_curtida.id_post', '=', 'tb_post.id')
        ->select(
            'tb_post.id as post_id',
            'tb_user.img_user',
            'tb_user.arroba_user',
            'tb_user.nome_user',
            'tb_post.titulo_post',
            'tb_post.descricao_post',
            'tb_post.conteudo_post',
            'tb_post.status_post',
            'tb_post.created_at',
        )
        ->where('tb_user.id', $instituicaoId)
        ->groupBy(
            'tb_post.id',
            'tb_post.titulo_post',
            'tb_user.img_user',
            'tb_user.arroba_user',
            'tb_user.nome_user',
            'tb_post.descricao_post',
            'tb_post.conteudo_post',
            'tb_post.status_post',
            'tb_post.created_at'
        )
        ->get();


        return view('instituicao.personalizacao-pagina.index', ['instituicao' => $instituicao, 'posts' => $posts]);

    }

    public function filtrar(Request $request){

        $instituicaoId = session('instituicao_id'); // Recupera o ID da instituição logada
        $instituicao = User::where('id', $instituicaoId)->first();
        
        $posts = DB::table('tb_post')
        ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
        ->leftJoin('tb_curtida', 'tb_curtida.id_post', '=', 'tb_post.id')
        ->select(
            'tb_post.id as post_id',
            'tb_post.titulo_post',
            'tb_post.descricao_post',
            'tb_post.conteudo_post',
            'tb_post.status_post',
            'tb_post.created_at',
            'tb_post.conteudo_post',
            DB::raw('COUNT(tb_curtida.id) as total_curtidas')
        )
        ->where('tb_user.id', $instituicaoId) 
        ->when($request->filled('visualizacao'), function ($query) use ($request) {
            
            return $query->where('tb_post.visualizacao', $request->visualizacao);
        })
        ->when($request->filled('mes'), function ($query) use ($request) {
            return $query->whereMonth('tb_post.created_at', $request->mes);
        })
        ->when($request->filled('restricao'), function ($query) use ($request) {
            return $query->where('tb_post.status_post', $request->restricao);
        })
        ->groupBy(
            'tb_post.id',
            'tb_post.titulo_post',
            'tb_post.descricao_post',
            'tb_post.conteudo_post',
            'tb_post.status_post',
            'tb_post.created_at'
        )
        ->get();



        return view('instituicao.biblioteca-midias.index', ['posts' => $posts, 'instituicao' => $instituicao]);
    }

    
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePersonalizacao(Request $request)
    {   
        $instituicaoId = session('instituicao_id'); // Recupera o ID da instituição logada
        $verificarInstituicao = User::where('id', $instituicaoId)->get();

        foreach($verificarInstituicao as $item){
            $nomeImagem = $item->img_user;
            $nomeBanner = $item->banner_user;
            if($request->hasFile('imgPerfil') && $request->file('imgPerfil')->isValid()){
                if($item->img_user && Storage::exists($item->img_user)){
                    Storage::delete($item->img_user);
                }
                $extensao = $request->imgPerfil->extension();
    
                $nomeImagem =   md5($request->imgPerfil->getClientOriginalName() . strtotime('now'). "." . $extensao);
    
                $request->imgPerfil->move(public_path('img/user/fotoPerfil/'), $nomeImagem);
            } if($request->hasFile('imgBanner') && $request->file('imgBanner')->isValid()){
                if($item->img_banner && Storage::exists($item->banner_user)){
                    Storage::delete($item->banner_user);
                }

                $extensaoBanner = $request->imgBanner->extension();

                $nomeBanner = md5($request->imgBanner->getClientOriginalName() . strtotime('now') . "." . $extensaoBanner);

                $request->imgBanner->move(public_path('img/user/bannerPerfil/'), $nomeBanner);
            }
           
        }
       
        $posts = DB::table('tb_post')
        ->join('tb_user', 'tb_post.id_user', '=', 'tb_user.id')
        ->leftJoin('tb_curtida', 'tb_curtida.id_post', '=', 'tb_post.id')
        ->select(
            'tb_post.id as post_id',
            'tb_user.img_user',
            'tb_user.arroba_user',
            'tb_user.nome_user',
            'tb_post.titulo_post',
            'tb_post.descricao_post',
            'tb_post.conteudo_post',
            'tb_post.status_post',
            'tb_post.created_at',
        )
        ->where('tb_user.id', $instituicaoId)
        ->groupBy(
            'tb_post.id',
            'tb_post.titulo_post',
            'tb_user.img_user',
            'tb_user.arroba_user',
            'tb_user.nome_user',
            'tb_post.descricao_post',
            'tb_post.conteudo_post',
            'tb_post.status_post',
            'tb_post.created_at'
        )
        ->get();

        $alterInstituicao = User::where('id', $instituicaoId)->update([
            'nome_user' => $request->nomeInstituicao,
            'bio_user' => $request->input('bioInstituicao'),
            'arroba_user' => $request->arrobaInstituicao,
            'img_user' => $nomeImagem,
            'banner_user' => $nomeBanner,
            'updated_at' => now()
        ]);
       
        $instituicao = User::where('id', $instituicaoId)->first();
        return view('instituicao.personalizacao-pagina.index', ['instituicao' => $instituicao, 'posts' => $posts]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
