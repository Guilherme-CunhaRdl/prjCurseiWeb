<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstituicaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// prefixo da area adm ---------------------------------------------------------------------------------------------------------

route::prefix('curseiAdm')->group(function(){
    
    // rotas de views
    Route::get('/','App\Http\Controllers\AdminController@index')->middleware('auth:adm');
    
    Route::get('/login', function () {
        return view('area-adm.login');
    })->name('login');
    Route::get('/usuarios','App\Http\Controllers\userController@usuariosAdm')->middleware('auth:adm')->name('usuario');
    Route::get('/denuncias','App\Http\Controllers\denunciaController@index')->middleware('auth:adm');
    route::get('/posts','\App\Http\Controllers\postController@index')->middleware('auth:adm');
    route::get('/curtai','\App\Http\Controllers\curteiController@index')->middleware('auth:adm');
    route::get('/configuracoes','\App\Http\Controllers\AdminController@edit')->middleware('auth:adm');
    Route::get('/instituicao','App\http\Controllers\AdminController@instituicoesAdm')->name('instituicao');
    Route::get('/tdPostInst','App\http\Controllers\AdminController@selectAllPostAdm');
    Route::get('/tdRellsInst','App\http\Controllers\AdminController@selectAllRellsAdm');
    Route::get('/dashUsuarioAdm/{id}','App\http\Controllers\AdminController@DashDoUserAdm');
    Route::get('/dashInstituicaoAdm/{id}','App\http\Controllers\AdminController@DashDaInstAdm');
    
    
    // funcões
    Route::get('/deslogar','App\Http\Controllers\AdminController@deslogar');
    Route::post('/logar','App\Http\Controllers\AdminController@logar');
    Route::get('/novoadm','App\Http\Controllers\AdminController@store');
    Route::get('/buscarUsuarios','App\Http\Controllers\userController@buscarUsuarios')->middleware('auth:adm');
    Route::get('/nomedoadm','App\Http\Controllers\AdminController@nome')->middleware('auth:adm');
    Route::get('/desativarUsuarios/{id}','App\Http\Controllers\userController@desativarUsuarios')->middleware('auth:adm');
    Route::get('/alterarAdm/{id}','App\Http\Controllers\AdminController@update')->middleware('auth:adm');
    Route::put('/usuario/{id}/atualizar', [AdminController::class, 'atualizar'])->name('usuario.atualizar');
    Route::put('/instituicao/{id}/atualizarDados', [AdminController::class, 'atualizarInst'])->name('instituicao.atualizarDados');
    Route::put('/instituicao/{id}/atualizarEndereco', [AdminController::class, 'atualizarInstDados'])->name('instituicao.atualizarEndereco');
});



// fim da area adm ---------------------------------------------------------------------------------------------------------

// inicio da area instituicao ---------------------------------------------------------------------------------------------------------


route::prefix('curseiInstituicao')->group( function(){
//rotas
Route::get('/dashboard', [InstituicaoController::class, 'index'])->name('dashboard.index');
Route::get('/login', [InstituicaoController::class, 'loginInstituicao'])->name('login');
Route::get('/analiseConteudo', [InstituicaoController::class, 'analiseConteudoInstituicao'])->name('analiseConteudo');
Route::get('/bibliotecaMidias', [InstituicaoController::class, 'bibliotecaMidiaIndex'])->name('biblioteca.index');
Route::get('/personalizacaoPagina', [InstituicaoController::class, 'personalizacaoIndex'])->name('personalizacao.index');

//funcoes
Route::post('/fazerLogin', [InstituicaoController::class, 'fazerLoginInstituicao'])->name('fazerLogin');
Route::get('/logoffInstituicao', [InstituicaoController::class, 'logoutInstituicao'])->name('logout');
Route::post('/personalizacaoPagina', [InstituicaoController::class, 'updatePersonalizacao'])->name('personalizacao.update');
Route::get('/bibliotecaMidia/filtrar', [InstituicaoController::class, 'filtrar'])->name('biblioteca.filtrar');


});

// fim da area instituicao ---------------------------------------------------------------------------------------------------------
