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

        <div class="cabecalhoUser gap-3">
          <div class="fotoUser ">
            <img src="{{ asset('img/user/fotoPerfil/' . ($usuario->img_user ?? 'default-banner.jpg')) }}" alt="Logo">
          </div>
          <div class="nome-botoes">
            <h2>{{ $usuario->nome_user }}</h2>
           @if($instituicao->verificado_instituicao == 0)
           <h5 onclick="abrirModalVerficar()">Pedido de verificação <i class='bx bxs-institution'></i>
           @endif
            </h5>
          </div>
        </div>
        <div class="buttonSair">
        @if($usuario->status_user == 1)
            <a href="/curseiAdm/desativarUsuarios/{{$usuario -> id}}" style="font-weight: 600; color:#8F0000; display: flex; gap: 10px; align-items: center; justify-content: center;">Desativar conta</a>
            @else
            <a href="/curseiAdm/ativarUsuarios/{{$usuario -> id}}" style="font-weight: 600; color:var(--verde); display: flex; gap: 10px; align-items: center; justify-content: center;">Ativar conta</a>
            @endif



        </div>
      </div>

     
      <div class="layout">

        <div class="conteudo-principal">

          <div class="estatisticas">
            <div class="itemDoUser">
              <i class="bi bi-people"></i>
              <div class="textoEstati">
                <span>{{ $numeroSeguidores }}</span>
                <p>Seguidores</p>
              </div>
            </div>

            <div class="itemDoUser">
              <i class="bi bi-image"></i>
              <div class="textoEstati">
                <span>{{ $numeroPosts }}</span>
                <p>Posts</p>
              </div>
            </div>

            <div class="itemDoUser">
              <i class="bi bi-camera-video"></i>
              <div class="textoEstati">
                <span>{{ $quantidadeCurtei }}</span>
                <p>Reels</p>
              </div>
            </div>

            <div class="itemDoUser">
              <i class="bi bi-heart"></i>
              <div class="textoEstati">
                <span>{{ $numeroCurtidas }}</span>
                <p>Curtidas</p>
              </div>
            </div>

            <div class="itemDoUser">
              <i class="bi bi-bookmark"></i>
              <div class="textoEstati">
                <span></span>
                <p>Favoritados</p>
              </div>
            </div>

            <div class="itemDoUser">
              <i class="bi bi-download"></i>
              <div class="textoEstati">
                <span></span>
                <p>Downloads</p>
              </div>
            </div>
          </div>


          <div class="painelInformacoes">
            <div class="d-flex justify-content-between align-items-center botoesInfo">
              <div class="d-flex align-items-center">
                <i class="bi bi-info-circle fs-5 me-2"></i>
                <h3 class="mb-0">Informações</h3>
              </div>

              <button onclick="abrirModalAlter()" class="botaoEdicao">
                <i class="bi bi-pencil-square fs-5" style="color:#05A4B6"></i>
              </button>

            </div>

            <p><strong>ID:</strong> {{ $usuario->id }} </p>
            <p><strong>Nome:</strong> {{ $usuario->nome_user }} </p>
            <p><strong>Email:</strong> {{ $usuario->email_user }} </p>
            <p><strong>Data de registro:</strong> {{ $instituicao->created_at }} </p>
            <p><strong>Ultima alteração:</strong> {{ $instituicao->updated_at }} </p>
            <p><strong>Ultima postagem:</strong> </p>
            <p><strong>Status da conta:</strong> {{ $usuario->status_user == 1 ? 'Ativo' : 'Desativado' }} </p>

          </div>


          <div class="painelInformacoes">
            <div class="d-flex justify-content-between align-items-center botoesInfo">
              <div class="d-flex align-items-center">
                <i class="bi bi-telephone fs-5 me-2"></i>
                <h3 class="mb-0">Endereço e Contato</h3>
              </div>

              <button onclick="abrirModalAlterInfo()" class="botaoEdicao">
                <i class="bi bi-pencil-square fs-5" style="color:#05A4B6"></i>
              </button>

            </div>

            <p><strong>Cnpj:</strong> {{ $instituicao->cnpj_instituicao }} </p>
            <p><strong>Contato:</strong> </p>
            <p><strong>Cep:</strong> {{ $instituicao->cep_instituicao }} </p>
            <p><strong>Endereço:</strong> {{ $instituicao->logradouro_instituicao }} </p>
            <p><strong>Numero:</strong> {{ $instituicao->num_logradouro_instituicao }} </p>
            <p><strong>Bairro:</strong> {{ $instituicao->bairro_instituicao }} </p>
            <p><strong>Cidade:</strong> {{ $instituicao->cnpj_instituicao }} </p>
            <p><strong>Estado:</strong> {{ $instituicao->estado_instituicao }} </p>
          </div>




        </div>

        <div class="painelInformacoes">
          <div class="grafico-box">
            <h3>Visualização por mês</h3>
            <h2 class="total-views">904.223</h2>
            <p class="sub-text">Total views</p>
            <canvas id="chartMes"></canvas>
          </div>
        </div>



      </div>




    </div>
  </main>


  <div class="container-fluid container-modal" id="contmodalInfo" onclick="fecharModalInfo(event)">
    <div class="modal-perfil" id="modal-perfil-perfil" style="">
      <div class="titulo-modal">
        Atualizar dados da instituicao
      </div>

      <form action="{{ route('instituicao.atualizarEndereco', ['id' => $usuario->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="inputs-modal">
          <p class="titulo-inputs">

<i class='bx bx-location-plus'></i> Endereço</p>
<div class="lista-de-inputs">
  <div class="input-modal-container">
    <label for="cep">Cep</label>
    <input type="text" name="cep" value="{{ $instituicao->cep_instituicao }}">
  </div>
  <div class="input-modal-container">
    <label for="endereço">Endereço</label>
    <input type="text" name="endereco" value="{{ $instituicao->num_logradouro_instituicao }}">
  </div>
  <div class="input-modal-container">
    <label for="numero">Numero</label>
    <input type="text" name="numero" value="{{ $instituicao->num_logradouro_instituicao }}">
  </div>
  <div class="input-modal-container">
    <label for="bairro">Bairro</label>
    <input type="text" name="bairro" value="{{ $instituicao->bairro_instituicao }}">
  </div>
  <div class="input-modal-container">
    <label for="cidade">Cidade</label>
    <input type="text" name="cidade" value="{{ $instituicao->cidade_instituicao }}">
  </div>
  <div class="input-modal-container">
    <label for="estado">Estado</label>
    <input type="text" name="estado" value="{{ $instituicao->estado_instituicao }} ">
  </div>
</div>
</div>
<div class="botoes-salva-cancelar">
  <button>Cancelar</button>
  <button class="salvar">Salvar</button>

  </form>
</div>
</div>
</div>



<!--Por favor Funciona-->
<div class="container-fluid container-modal" id="contmodal" onclick="fecharModal(event)">
  <div class="modal-perfil" id="modal-perfil" style="">
    <div class="titulo-modal">
      Editar conta do usuario
    </div>

    <form action="{{ route('instituicao.atualizarDados', $usuario->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="topo-modal">
        <div class="banner-modal">
          <img src="{{ asset('img/user/bannerPerfil/' . ($usuario->banner_user ?? 'default-banner.jpg')) }}" alt="">
        </div>
        <div class="abaixo-do-banner">
          <div class="img-perfil-modal">
            <img src="{{ asset('img/user/fotoPerfil/' . ($usuario->img_user ?? 'default-banner.jpg')) }}" alt="">
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
        <p class="titulo-inputs"><i class='bx bx-info-circle'></i> Informações</p>
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
</div>
<div class="cont-modal-verificar" onclick="fecharModalVerificar(event)">
        <div class="modal-verificar">
          <h2>Verificar Instituição </h2>
        <p> Esse usuário solicitou a conversão da sua conta para uma conta de instituição.</p>
        <div>
          <a id="recusar" href="/curseiAdm/verificarInts/{{$usuario -> id}}/recusar">Recusar</a>
          <a href="/curseiAdm/verificarInts/{{$usuario -> id}}/aprovar">Aceitar</a>
        </div>
        </div>
      </div>



<script src="{{asset('js/abrirModalUser.js')}}"></script>
<script src="{{asset('js/abrirModalInfo.js')}}"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
  crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</body>

</html>