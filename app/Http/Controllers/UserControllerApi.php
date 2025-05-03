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
    if ($request->hasFile('imgUser')) {
        $imagemPerfil = $request->file('imgUser');
        
        // Define o nome do arquivo (ex: time() + extensão)
        $nomeImagem = time() . '_' . uniqid() . '.' . $imagemPerfil->getClientOriginalExtension();
    
        // Move o arquivo para a pasta public/img
        $imagemPerfil->move(public_path('img/user/fotoPerfil'), $nomeImagem);
    }
     
    if ($request->hasFile('bannerUser')) {
        $imagemBanner = $request->file('bannerUser');

        $nomeBanner = time() . '_' . uniqid() . '.' . $imagemBanner->getClientOriginalExtension();

        $imagemBanner->move(public_path('img/user/bannerPerfil'), $nomeBanner);
        }

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
    
    return response()->json([
        'sucesso' => true,
        'mensagem' => 'Usuário Cadastrado com Sucesso!',
        'code' => 200,
        'User' => $user,
    ]);
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
    
}