<?php

namespace App\Http\Controllers;

use Illuminate\Cache\Events\WritingKey;
use Illuminate\Http\Request;
use App\Models\User;
use PhpParser\Node\Expr\FuncCall;

use function PHPUnit\Framework\returnSelf;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function usuariosAdm()
    {
        $allUsers = User::all();

        return view('area-adm.usuarios')->with('usuarios',$allUsers);

    }
    public function buscarUsuarios(Request $request){
         $pesquisa = $request ->input('pesquisa');
         $filtro = $request ->input('filtro');
         $organizar = $request ->input('organizar');

         $query = User::where('nome_user','like',"%$pesquisa%");
         if ($filtro !=="all"){
            if($filtro == "on"){
                $filtro = 1;
            }else{
                $filtro = 0;
            }
            $query = $query->where('status_user',"$filtro");
         }
        
            if($organizar == "recent"){
                $organizar = 'asc';
            }elseif($organizar =="old"){
                $organizar = 'desc';
            }
            $query = $query->orderBy('created_at',"$organizar");
         
         
         $resultado = $query->get();
         return response()->json($resultado);
    }
    public function desativarUsuarios($id){
        $usuario =User::findOrFail($id);
        $usuario->status_user = 0;
        $usuario->save();
        return back();
    }
    public function ativarUsuarios($id){
        $usuario =User::findOrFail($id);
        $usuario->status_user = 1;
        $usuario->save();
        return back();
    }

}
