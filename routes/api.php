<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostControllerApi;
use App\Http\Controllers\UserControllerApi;
use App\Http\Controllers\InstituicaoControllerApi;
use App\Http\Controllers\MensagemControllerApi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts/{tipo}/{idUser}/{quantidade}/{pagina}/{pesquisa}', [PostControllerApi::class, 'posts'])->name('posts.index');
Route::post('/posts/interacoes/{acao}', [PostControllerApi::class, 'interacoes'])->name('posts.interacoes');

 Route::get('/cursei/posts', [PostControllerApi::class, 'indexApi'])->name('posts.index');
 Route::post('/cursei/posts/{idUser}', [PostControllerApi::class, 'storeApi'])->name('posts.store');
 Route::get('/cursei/posts/user/{idUser}', [PostControllerApi::class, 'getPostsByUser'])->name('posts.byUser');
 Route::post('instituicao', [instituicaoControllerApi::class, 'cadastrarInstituicao']);
 
 Route::get('/verificar-email', [UserControllerApi::class, 'verificarEmailExistente']);
Route::get('/verificar-usuario', [UserControllerApi::class, 'verificarUsuarioExistente']);

Route::get('/cursei/user', [UserControllerApi::class, 'indexApi'])->name('user.index');
Route::post('/cursei/user', [UserControllerApi::class, 'storeApi'])->name('user.store');
Route::delete('/cursei/user/{id}', [UserControllerApi::class, 'destroyApi'])->name('user.destroy');
Route::put('/cursei/user/{id}', [UserControllerApi::class, 'updateApi'])->name('user.update');
Route::get('/cursei/user/{id}', [UserControllerApi::class, 'showApi'])->name('user.show');
Route::post('/cursei/user/logar/', [UserControllerApi::class, 'selectUserLogin'])->name('user.login');

//rotas do chat
Route::get('/cursei/chat/{idChat}', [MensagemControllerApi::class, 'selectMensagensApi'])->name('chat.todosChats');
Route::get('/cursei/chat/recebidor/{idUserRecebidor}', [MensagemControllerApi::class, 'selectChatApi'])->name('chat.todosChats');
Route::get('/cursei/chat/adicionarChat/{idUserLogado}', [MensagemControllerApi::class, 'selectSeguidoresSugestoes'])->name('chat.telaSeguidores');
Route::post('/cursei/chat/adicionarChat/', [MensagemControllerApi::class, 'criarChat'])->name('chat.criarChat');
Route::get('/cursei/chat/adicionarChat/{idUserLogado}/{idSeguidor}', [MensagemControllerApi::class, 'selectSeguidor'])->name('chat.seguidor');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
