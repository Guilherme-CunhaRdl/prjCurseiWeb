<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @include('area-adm.componentes.links-base')
    <link rel="stylesheet" href="{{asset('css/dashboardUser.css')}}">
    <link rel="stylesheet" href="{{asset('css/instituicoesAdm.css')}}">
</head>
<body>
    @include('area-adm.componentes.sidebar')
    
    <main>
        <div class="painel-usuario">

            <div class="headerUserAdm">
                <div class="cabecalhoUser">
                    <div class="fotoUser">
                        <img src="{{ asset('img/user/fotoPerfil/' . ($usuario->img_user ?? 'default-avatar.jpg')) }}" alt="Foto do usuário">
                    </div>
                    <h2>{{ $usuario->nome_user }}</h2>
                </div>
                
                <div class="buttonSair">
                    @if($usuario->status_user == 1)
                        <a href="/curseiAdm/desativarUsuarios/{{$usuario->id}}" class="botaoSair">
                            <i class="bi bi-power"></i> Desativar conta
                        </a>
                    @else
                        <a href="/curseiAdm/ativarUsuarios/{{$usuario->id}}" style="color: var(--verde);">
                            <i class="bi bi-power"></i> Ativar conta
                        </a>
                    @endif
                </div>
            </div>


            <div class="layout">

                <div class="conteudo-principal">

                    <div class="estatisticasUser">
                        <div class="itemDoUsuario">
                            <i class="bi bi-people"></i>
                            <div class="textoEstatiUser">
                                <span>{{ $numeroSeguidores}}</span>
                                <p>Seguidores</p>
                            </div>
                        </div>

                        <div class="itemDoUsuario">
                            <i class="bi bi-file-post"></i>
                            <div class="textoEstatiUser">
                                <span>{{ $numeroPosts }}</span>
                                <p>Posts</p>
                            </div>
                        </div>

                        <div class="itemDoUsuario">
                            <i class="bi bi-camera-reels"></i>
                            <div class="textoEstatiUser">
                                <span>{{ $quantidadeCurtei }}</span>
                                <p>Reels</p>
                            </div>
                        </div>

                        <div class="itemDoUsuario">
                            <i class="bi bi-heart"></i>
                            <div class="textoEstatiUser">
                                <span>{{ $numeroCurtidas }}</span>
                                <p>Curtidas</p>
                            </div>
                        </div>
                    </div>
                    
            <div class="listas-container">
                    <div class="listaSeguidores">
                        <div class="textoSeguidores">
                            <h3><i class="bi bi-people-fill"></i> Seguidores</h3>
                            <span>{{ $numeroSeguidores }}</span>
                        </div>
                        <ul>
                            @foreach ($ultimosSeguidores as $seg)
                                <li>
                                    <img src="{{ asset('img/user/fotoPerfil/' . ($seg->usuarioSeguidor->img_user ?? 'default-avatar.jpg')) }}" alt="Seguidor">
                                    {{ $seg->usuarioSeguidor->nome_user ?? 'Usuário removido' }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="listaSeguidores">
                        <div class="textoSeguidores">
                            <h3><i class="bi bi-person-plus-fill"></i> Seguindo</h3>
                            <span>{{ $numeroSeguindo }}</span>
                        </div>
                        <ul>
                            @foreach ($seguindo as $segui)
                                <li>
                                    <img src="{{ asset('img/user/fotoPerfil/' . ($segui->usuarioSeguido->img_user ?? 'default-avatar.jpg')) }}" alt="Seguindo">
                                    {{ $segui->usuarioSeguido->nome_user ?? 'Usuário removido' }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>


                <div class="painelInformacoes">
                    <div class="botoesInfo">
                        <h3><i class="bi bi-info-circle"></i> Informações</h3>
                        <!--<button onclick="abrirModalAlter()" class="botaoEdicao">
                            <i class="bi bi-pencil-square"></i>
                        </button>-->
                    </div>
                
                    <p><strong>ID:</strong> {{ $usuario->id }}</p>
                    <p><strong>Nome:</strong> {{ $usuario->nome_user }}</p>
                    <p><strong>Email:</strong> {{ $usuario->email_user }}</p>
                    <p><strong>Data de registro:</strong> {{ date('d/m/Y H:i', strtotime($usuario->created_at)) }}</p>
                    <p><strong>Última atualização:</strong> {{ date('d/m/Y H:i', strtotime($usuario->updated_at)) }}</p>
                    <p>
                        <strong>Status:</strong> 
                        <span style="color: {{ $usuario->status_user == 1 ? 'var(--verde)' : 'var(--vermelho)' }};">
                            {{ $usuario->status_user == 1 ? 'Ativo' : 'Desativado' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </main>


    <div class="container-fluid container-modal" id="contmodal" onclick="fecharModal(event)">
        <div class="modal-perfil" id="modal-perfil">
            <div class="titulo-modal">
                <i class="bi bi-person-gear"></i> Editar conta do usuário
            </div>

            <form action="{{ route('usuario.atualizar', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="topo-modal">
                <div class="banner-modal">
                    <img id="banner-preview" src="{{ asset('img/user/bannerPerfil/' . ($usuario->banner_user ?? 'default-banner.jpg')) }}" alt="Banner">
                </div>
                <div class="abaixo-do-banner">
                    <div class="img-perfil-modal">
                        <img id="foto-preview" src="{{ asset('img/user/fotoPerfil/' . ($usuario->img_user ?? 'default-avatar.jpg')) }}" alt="Foto de perfil">
                    </div>
                    <div class="botoes-alter-modal">
                        <label for="foto-upload" class="upload-label">
                            <i class="bi bi-camera"></i> Alterar foto de perfil
                        </label>
                        <input type="file" id="foto-upload" class="upload-input" name="foto" accept="image/*">

                        <label for="banner-upload" class="upload-label">
                            <i class="bi bi-image"></i> Alterar foto do banner
                        </label>
                        <input type="file" id="banner-upload" class="upload-input" name="banner" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="inputs-modal">
                <p class="titulo-inputs"><i class='bx bx-info-circle' ></i> Informações</p>
                <div class="lista-de-inputs">
                    <div class="input-modal-container">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" value=" {{ $usuario->nome_user }}">
                    </div>
                    <div class="input-modal-container">
                        <label for="usuario">Usuario</label>
                        <input type="text" name="usuario" value="{{ $usuario->arroba_user }}">
                    </div>
                    <div class="input-modal-container">
                        <label for="email">Email</label>
                        <input type="text" name="email" value="{{ $usuario->email_user }}">
                    </div>
                    <div class="input-modal-container">
                        <label for="senha">Senha</label>
                        <input type="text" name="senha" value="">
                    </div>
                </div>
            </div>
            <div class="botoes-salva-cancelar">
                <button>Cancelar</button>
                <button class="salvar">Salvar</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/abrirModalUser.js')}}"></script>

</body>
</html>