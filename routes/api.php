<?php

use App\Http\Controllers\ExplorarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostControllerApi;
use App\Http\Controllers\UserControllerApi;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\InstituicaoControllerApi;
use App\Http\Controllers\MensagemControllerApi;
use App\Http\Controllers\HashtagController;
use App\Http\Controllers\CurteiController;
use App\Http\Controllers\DestaqueController;

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

Route::get('/user/verificarInteresses/{id}', [UserControllerApi::class, 'verificarPreferencia'])->name('user.verificarPreferencia');
Route::post('/user/escolherInteresesses', [UserControllerApi::class, 'escolherInteresesses'])->name('user.escolherInteresesses');

 Route::get('/cursei/posts', [PostControllerApi::class, 'indexApi'])->name('posts.index');
Route::post('/cursei/postsUpdate/{id}', [PostControllerApi::class, 'updateApi'])->name('posts.update');
 Route::post('/cursei/evento/{idUser}', [PostControllerApi::class, 'criarEvento'])->name('posts.criarEvento');
 Route::get('/cursei/evento/{id}', [PostControllerApi::class, 'showEvento'])->name('posts.verEvento');
 Route::post('/cursei/eventoUpdate', [PostControllerApi::class, 'editEvento'])->name('posts.editEvento');
 Route::get('/cursei/lembreteEvento/{idEvento}/{idUser}', [UserControllerApi::class, 'lembreteEvento'])->name('user.lembreteEvento');
 Route::post('/cursei/posts/impulsionar', [PostControllerApi::class, 'impulsionar'])->name('posts.impulsionar');

 Route::post('/cursei/posts/{idUser}', [PostControllerApi::class, 'storeApi'])->name('posts.store');
 Route::get('/cursei/posts/user/{idUser}', [PostControllerApi::class, 'getPostsByUser'])->name('posts.byUser');

Route::post('instituicao', [instituicaoControllerApi::class, 'cadastrarInstituicao']);
Route::get('/cursei/instituicao/procurarInstituicao/{pesquisa}', [instituicaoControllerApi::class, 'procurarInstituicao'])->name('instituicao.procurarInstituicao');
Route::get('/cursei/instituicao/verificarInstituicao/{id}', [InstituicaoControllerApi::class, 'verificarInstituicaoSolicitada'])->name('instituicao.verificarInstituicao');

 Route::get('/verificar-email', [UserControllerApi::class, 'verificarEmailExistente']);
Route::get('/verificar-usuario', [UserControllerApi::class, 'verificarUsuarioExistente']);

Route::get('/cursei/user', [UserControllerApi::class, 'indexApi'])->name('user.index');
Route::post('/cursei/user', [UserControllerApi::class, 'storeApi'])->name('user.store');
Route::delete('/cursei/user/{id}', [UserControllerApi::class, 'destroyApi'])->name('user.destroy');
Route::put('/cursei/user/{id}', [UserControllerApi::class, 'updateApi'])->name('user.update');
Route::get('/cursei/user/{idPerfil}/{idUser}', [UserControllerApi::class, 'showApi'])->name('user.show');
Route::get('/cursei/user/verificarSeSegue/{idUser}/{idPerfil}', [UserControllerApi::class, 'verificarSeSegue'])->name('user.verificarSeSegue');
Route::get('/cursei/user/seguidoresSeguindo/{id}/{acao}', [UserControllerApi::class, 'BuscarSeguidoresSeguindo'])->name('user.BuscarSeguidoresSeguindo');
Route::get('/cursei/user/deseguirOuTirarSeguidor/{idUser}/{idPerfil}/{acao}', [UserControllerApi::class, 'deseguirOuTirarSeguidor'])->name('user.deseguirOuTirarSeguidor');
Route::get('/cursei/user/notificacao/{id}/{acao}', [UserControllerApi::class, 'notificacao'])->name('user.notificacao');
Route::get('/cursei/user/sugerirUsuario/{idUser}/{limite}', [UserControllerApi::class, 'sugerirUsuario'])->name('user.sugerirUsuario');
Route::get('/cursei/user/procurarUsuario/{pesquisa}/{idUser}', [UserControllerApi::class, 'procurarUsuario'])->name('user.procurarUsuario');
Route::get('/cursei/user/desbloquear/{idPerfil}/{idUser}', [UserControllerApi::class, 'debloquearUser'])->name('user.debloquearUser');

Route::post('/cursei/user/update-perfil/{id}', [UserControllerApi::class, 'updatePerfilApi']);

Route::post('/cursei/user/logar/', [UserControllerApi::class, 'selectUserLogin'])->name('user.login');

//rotas do chat
Route::get('/cursei/chat/mensagens/{idChat}', [MensagemControllerApi::class, 'selectMensagensApi'])->name('chat.todosChats');
Route::get('/cursei/chat/mensagensCanal/{idEnviador}/{idCanal}', [MensagemControllerApi::class, 'selectMensagensCanalApi'])->name('chat.todosChats');
Route::get('/cursei/chat/recebidor/{idUserRecebidor}/{tipo}/{pesquisa}', [MensagemControllerApi::class, 'selectChatApi'])->name('chat.todosChats');
Route::get('/cursei/chat/adicionarChat/{idUserLogado}', [MensagemControllerApi::class, 'selectSeguidoresSugestoes'])->name('chat.telaSeguidores');
Route::get('/cursei/chat/adicionarChat/conexoes/{idUserLogado}', [MensagemControllerApi::class, 'selectSeguidoresConexoes'])->name('chat.cconexoes');
Route::get('/cursei/chat/adicionarChat/sugestoes/{idUserLogado}', [MensagemControllerApi::class, 'selectAddChatSugestoes'])->name('chats.sugestoes');
Route::post('/cursei/chat/adicionarChat/', [MensagemControllerApi::class, 'criarChat'])->name('chat.criarChat');
Route::post('/cursei/chat/enviarMensagem/{tipoMensagem}', [MensagemControllerApi::class, 'enviarMensagem'])->name('chat.enviarMensagem');
Route::post('/cursei/chat/enviarMensagem/canal/{tipoMensagem}', [MensagemControllerApi::class, 'enviarMensagemCanal'])->name('chat.enviarMensagem');
Route::get('/cursei/chat/adicionarChat/{idUserLogado}/{idSeguidor}', [MensagemControllerApi::class, 'selectSeguidor'])->name('chat.seguidor');
Route::post('/cursei/chat/criarCanal', [MensagemControllerApi::class, 'criarCanal'])->name('chat.criarCanal');
Route::get('/cursei/chat/selecionarCanais/{id}', [MensagemControllerApi::class, 'selectCanaisApi']); 
Route::post('/cursei/chat/seguirCanal', [MensagemControllerApi::class, 'seguirCanal']); 
Route::delete('/cursei/chat/deixarSeguir/{id}', [MensagemControllerApi::class, 'deixarSeguir']); 

Route::post('cursei/user/atualizar/{userId}', [UserControllerApi::class, 'alterarUser']); 
Route::post('cursei/user/alterarSenha/{userId}', [UserControllerApi::class, 'alterarSenha']);

Route::post('cursei/user/autenticacao/{userId}', [UserControllerApi::class, 'atualizarDoisFatores']);

Route::post('/cursei/user/selecionarUser/{id}', [UserControllerApi::class, 'selectUser']);

//ROTAS DO CURTEI
Route::group(['middleware' => ['cors']], function() {
    Route::post('/curtei/upload', [CurteiController::class, 'storeCurtei']);
    Route::get('/curtei/videos', [CurteiController::class, 'mostrarVideos']);
});
 

//rotas para o explorar
Route::get('/cursei/explorar/assuntosMomento',[HashtagController::class, 'maisUsadas'])->name('explorar.maisUsadas');
Route::get('/cursei/explorar/recomendarHashtags/{id}',[HashtagController::class, 'recomendarHashtags'])->name('explorar.recomendarHashtags');

//ROTAS DO CURTEI
Route::post('/curtei/upload', [CurteiController::class, 'storeCurtei']);
Route::get('/curtei/videos', [CurteiController::class, 'mostrarVideos']);
Route::delete('/curtei/deletar/{id}', [CurteiController::class, 'destroy']);
Route::post('/curtei/update/{id}', [CurteiController::class, 'updateCurtei']);


Route::post('/curtei/{curtei}/curtir', [CurteiController::class, 'curtir']);
Route::post('/curtei/{curtei}/descurtir', [CurteiController::class, 'descurtir']);
Route::get('/curtidas/usuario/{userId}', [CurteiController::class, 'curtidasPorUsuario']);
Route::post('/curtei/comentarios', [CurteiController::class, 'comentarios']);
Route::post('/curtei/comentarios/adicionar', [CurteiController::class, 'adicionarComentario']);
Route::post('/curtei/comentarios/curtir', [CurteiController::class, 'curtirComentario']);




//ROTAS DOS STORYES
Route::post('/stories/upload', [StoryController::class, 'upload']);
    Route::get('/stories', [StoryController::class, 'index']);
    Route::delete('/stories/{id}', [StoryController::class, 'destroy']);


//ROTAS DOS DESTAQUES

    // Listar destaques de um usuário específico
        Route::get('/destaques/{id_user}', [DestaqueController::class, 'index']);
        Route::post('/destaques/{id_user}', [DestaqueController::class, 'store']);
        Route::delete('/destaques/{id_user}/{id}', [DestaqueController::class, 'destroy']);
        Route::put('/destaques/{id_destaque}/stories', [DestaqueController::class, 'atualizarDestaques']);