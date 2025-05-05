<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexApi()
    {
        $users = User::all();

        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function storeApi(Request $request)
     {   
         try {
             // Verificação de email
             $emailExistente = User::where('email_user', $request->emailUser)->exists();
             if ($emailExistente) {
                 return response()->json([
                     'sucesso' => false,
                     'mensagem' => 'Este email já está cadastrado',
                     'error' => 'email_existente'
                 ], 422);
             }
     
             // Verificação de usuário
             $usuarioExistente = User::where('arroba_user', $request->arrobaUser)->exists();
             if ($usuarioExistente) {
                 return response()->json([
                     'sucesso' => false,
                     'mensagem' => 'Este nome de usuário já está em uso',
                     'error' => 'usuario_existente'
                 ], 422);
             }
     
             // Processamento de imagens
             $nomeImagem = null;
             $nomeBanner = null;
     
             if ($request->hasFile('imgUser') && $request->file('imgUser')->isValid()) {
                 $extensao = $request->file('imgUser')->getClientOriginalExtension();
                 $nomeImagem = time() . '_' . uniqid() . '.' . $extensao;
                 $request->file('imgUser')->move(public_path('img/user/fotoPerfil'), $nomeImagem);
             }
     
             if ($request->hasFile('bannerUser') && $request->file('bannerUser')->isValid()) {
                 $extensaoBanner = $request->file('bannerUser')->getClientOriginalExtension();
                 $nomeBanner = time() . '_' . uniqid() . '.' . $extensaoBanner;
                 $request->file('bannerUser')->move(public_path('img/user/bannerPerfil'), $nomeBanner);
             }
     
             // Criação do usuário
             $user = User::create([
                 'nome_user' => $request->nomeUser,
                 'email_user' => $request->emailUser,
                 'senha_user' => bcrypt($request->senhaUser),
                 'img_user' => $nomeImagem,
                 'banner_user' => $nomeBanner,
                 'status_user' => 1,
                 'bio_user' => $request->bioUser,
                 'arroba_user' => $request->arrobaUser,
                 'created_at' => now(),
             ]);
     
             if (!$user) {
                 throw new \Exception('Falha ao criar usuário');
             }
     
             return response()->json([
                 'sucesso' => true,
                 'mensagem' => 'Usuário Cadastrado com Sucesso!',
                 'code' => 200,
                 'User' => $user,
             ]);
     
         } catch (\Illuminate\Database\QueryException $e) {
             $errorCode = $e->errorInfo[1];
             
             if($errorCode == 1062) {
                 if (str_contains($e->getMessage(), 'email_user')) {
                     return response()->json([
                         'sucesso' => false,
                         'mensagem' => 'Este email já está cadastrado (erro de banco)',
                         'error' => 'email_existente'
                     ], 422);
                 } elseif (str_contains($e->getMessage(), 'arroba_user')) {
                     return response()->json([
                         'sucesso' => false,
                         'mensagem' => 'Este nome de usuário já está em uso (erro de banco)',
                         'error' => 'usuario_existente'
                     ], 422);
                 }
             }
             
             return response()->json([
                 'sucesso' => false,
                 'mensagem' => 'Ocorreu um erro inesperado. Tente novamente mais tarde.',
                 'error' => 'database_error'
             ], 500);
             
         } catch (\Exception $e) {
             return response()->json([
                 'sucesso' => false,
                 'mensagem' => 'Ocorreu um erro durante o cadastro: ' . $e->getMessage(),
                 'error' => 'unexpected_error'
             ], 500);
         }
     }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showApi($id)
    {
        $user = User::withCount(['seguidor', 'seguindo'])
        ->where('id', $id)
        ->first();


    
        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Usuario Encontrado com Sucesso!',
            'code' => 200,
            'User' => $user
        ]);
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
    public function updateApi(Request $request, $id)
    {
        $verificarUser = User::all()->where('id', $id);

        foreach($verificarUser as $item){
            if($request->hasFile('imgUser') && $request->file('imgUser')->isValid()){
                
                if($item->img_user && Storage::exists($item->img_user)){
                    Storage::delete($item->img_user);
                }
    
                $extensao = $request->imgUser->extension();
    
                $nomeImagem =   md5($request->imgUser->getClientOriginalName() . strtotime('now'). "." . $extensao);
    
                $request->imgUser->move(public_path('img/img-instituicao/img-perfil'), $nomeImagem);
    
            } if($request->hasFile('bannerUser') && $request->file('bannerUser')->isValid()){
                if($item->img_banner && Storage::exists($item->banner_user)){
                    Storage::delete($item->banner_user);
                }
    
                $extensaoBanner = $request->bannerUser->extension();
    
                $nomeBanner = md5($request->bannerUser->getClientOriginalName() . strtotime('now') . "." . $extensaoBanner);
    
                $request->bannerUser->move(public_path('img/img-instituicao/banners/'), $nomeBanner);
            }
        }
       

        $user = User::where('id', $id)->update([
            'nome_user' => $request->nomeUser,
            'email_user' => $request->emailUser,
            'senha_user' => Hash::make($request->senhaUser),
            'img_user' =>  $nomeImagem,
            'banner_user' => $nomeBanner,
            'status_user' => $request->statusUser,
            'bio_user' => $request->bioUser,
            'arroba_user' => $request->arrobaUser,
            'updated_at' => now()
        ]); 

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Usuario Atualizado com Sucesso!',
            'code' => 200,
            'Post' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyApi($id)
    {
        $user = User::where('id', $id)->delete();

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Usuario Excluído com Sucesso!',
            'code' => 200,
        ]);
    }
    public function selectUserLogin(Request $request)
    {
        try{

            $user = User::where('email_user', $request->emailDigitado)->first();

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Fim do Processo',
                'code' => 200,
                'usuario' => $user
            ]);

        }catch(Exception $e){

            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Fim do Processo',
                'code' => 200,
                'error' => $e
            ]);
        }

    }

    public function verificarEmailExistente(Request $request)
    {
        $email = $request->query('email');
        $existe = User::where('email_user', $email)->exists();
        
        return response()->json([
            'existe' => $existe
        ]);
    }
    
    public function verificarUsuarioExistente(Request $request)
    {
        $usuario = $request->query('usuario');
        $existe = User::where('arroba_user', $usuario)->exists();
        
        return response()->json([
            'existe' => $existe
        ]);
    }

    
}