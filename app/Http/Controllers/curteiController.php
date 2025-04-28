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
