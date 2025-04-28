<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard Do Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @include('area-adm.componentes.links-base')
    <link rel="stylesheet" href="{{asset('css/instituicoesAdm.css')}}">
</head>
<body>
@include('area-adm.componentes.sidebar')
    <main>
        <div class="painel-usuario">

        <div class="headerUserAdm">

            <div class="cabecalhoUser">
                <img class="fotoUser" src="{{ asset('img/user/fotoPerfil/' . ($usuario->img_user ?? 'default-banner.jpg')) }}" alt="Logo">
                <h2>{{ $usuario->nome_user }}</h2>
            </div>
          <div class="buttonSair">
          <a href="/curseiAdm/desativarUsuarios/{{$usuario -> id}}"><button class="botaoSair">DESATIVAR CONTA<i class="bi bi-x-circle" style="color:#8F0000;"></i></i></a>



          </div>
        </div>

      
<div class="layout">

            <div class="conteudo-principal">

              <div class="estatisticasUser">
      <div class="itemDoUsuario">
          <i class="bi bi-person fs-1"></i>
          <div class="textoEstatiUser">
              <span>{{ $numeroSeguidores }}</span>
              <p>Seguidores</p>
          </div>
      </div>

      <div class="itemDoUsuario">
      <i class="bi bi-image fs-1"></i>
          <div class="textoEstatiUser">
              <span>{{ $numeroPosts }}</span>
              <p>Posts</p>
          </div>
      </div>

      <div class="itemDoUsuario">
      <i class="bi bi-camera-video fs-1"></i>
          <div class="textoEstatiUser">
              <span>{{ $quantidadeCurtei }}</span>
              <p>Reels</p>
          </div>
      </div>

      <div class="itemDoUsuario">
      <i class="bi bi-heart fs-1"></i>
          <div class="textoEstatiUser">
              <span>{{ $numeroCurtidas }}</span>
              <p>Curtidas</p>
          </div>
      </div>
  </div>
            

        <div class="listaSeguidores">
          <div class="textoSeguidores"><h3>Seguidores </h3> <span>{{ $numeroSeguidores }}</span> </div>
          <ul>
          @foreach ($ultimosSeguidores as $seg)
            <li><img src="{{ asset('img/user/fotoPerfil/' . ($seg->usuarioSeguidor->img_user ?? 'default-banner.jpg')) }}">{{ $seg->usuarioSeguidor->nome_user ?? 'Desconhecido' }}</li>
          @endforeach
           
           
      
          </ul>
        </div>

        <div class="listaSeguidores">
          <div class="textoSeguidores"><h3>Seguindo </h3> <span>{{ $numeroSeguindo }}</span> </div>
          <ul>
          @foreach ($seguindo  as $segui)
            <li><img src="{{ asset('img/user/fotoPerfil/' . ($segui->usuarioSeguido->img_user ?? 'default-banner.jpg')) }}">{{ $segui->usuarioSeguido->nome_user ?? 'Desconhecido' }}</li>
          @endforeach
          </ul>
        </div>


        </div>


        <div class="painelInformacoes">
            <div class="d-flex justify-content-between align-items-center botoesInfo">
              <div class="d-flex align-items-center">
                <i class="bi bi-info-circle fs-5 me-2"></i>
                <h3 class="mb-0">Informações</h3>
              </div>
              <button  onclick="abrirModalAlter()" >
                <i class="bi bi-pencil-square fs-5" style="color:#05A4B6"></i>
              </button>
            </div>
         
          <p><strong>ID:</strong> {{ $usuario->id }} </p>
          <p><strong>Nome:</strong> {{ $usuario->nome_user }} </p>
          <p><strong>Email:</strong> {{ $usuario->email_user }} </p>

          <p><strong>Data de registro:</strong> {{ $usuario->created_at }} </p>
          <p><strong>Ultima alteração:</strong> {{ $usuario->updated_at }} </p>

          <p><strong>Status da conta:</strong>  {{ $usuario->status_user == 1 ? 'Ativo' : 'Desativado' }} </p>

        </div>

  </div>


        </div>


        
    </main>

    <div class="container-fluid container-modal" id="contmodal" onclick="fecharModal(event)" >
        <div class="modal-perfil" id="modal-perfil" style="height: 700px;">
            <div class="titulo-modal">
                Editar conta do usuario
            </div>

            <form action="{{ route('usuario.atualizar', $usuario->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="topo-modal">
                <div class="banner-modal">
                    <img src="{{ asset('img/user/bannerPerfil/' . ($usuario->banner_user ?? 'default-banner.jpg')) }}" alt="">
                </div>
                <div class="abaixo-do-banner">
                    <div class="img-perfil-modal">
                        <img src="{{ asset('img/user/fotoPerfil/' . ($usuario->img_user ?? 'default-avatar.jpg')) }}" alt="">
                    </div>
                    <div class="botoes-alter-modal">
                    <label for="banner-upload" class="upload-label">Alterar foto de perfil</label>
                    <input type="file" id="banner-upload" class="upload-input" name="foto">

                    <label for="banner" class="upload-label">Alterar foto do banner</label>
                    <input type="file" id="banner" class="upload-input" name="banner">
                        
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
                        <input type="text" name="senha" value="{{ $usuario->senha_user }}">
                    </div>
                </div>
            </div>
            <!-- <div class="inputs-modal">
                <p class="titulo-inputs"></html><i class='bx bx-location-plus' ></i> Endereço</p>
                <div class="lista-de-inputs">
                    <div class="input-modal-container">
                        <label for="cep">Cep</label>
                        <input type="text" name="cep" value="ChaveDo.grau22@gmail.com">
                    </div>
                    <div class="input-modal-container">
                        <label for="endereço">Endereço</label>
                        <input type="text" name="endereço" value="">
                    </div>
                    <div class="input-modal-container">
                        <label for="numero">Numero</label>
                        <input type="text" name="numero" value="">
                    </div>
                    <div class="input-modal-container">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" value="">
                    </div>
                    <div class="input-modal-container">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" value="">
                    </div>
                    <div class="input-modal-container">
                        <label for="estado">Estado</label>
                        <input type="text" name="estado" value="">
                    </div>
                </div>
            </div> -->
            <div class="botoes-salva-cancelar">
                <button>Cancelar</button>
                <button class="salvar">Salvar</button>

</form>
            </div>
        </div>
    </div>



    <script src="{{asset('js/abrirModalUser.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>
</html>