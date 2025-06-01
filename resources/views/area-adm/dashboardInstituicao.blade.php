<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard da Instituição</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  @include('area-adm.componentes.links-base')
  <link rel="stylesheet" href="{{asset('css/instituicoesAdm.css')}}">
  <link rel="stylesheet" href="{{asset('css/dashboardInst.css')}}">
</head>

<body>
  @include('area-adm.componentes.sidebar')
  <main>
    <div class="painel-usuario">

      <!-- Cabeçalho -->
      <div class="headerUserAdm">
        <div class="cabecalhoUser gap-3">
          <div class="fotoUser">
            <img src="{{ asset('img/user/fotoPerfil/' . ($usuario->img_user ?? 'default-banner.jpg')) }}" alt="Logo" class="img-fluid">
          </div>
          <div class="nome-botoes text-center text-md-start">
            <h2>{{ $usuario->nome_user }}</h2>
            @if($instituicao->verificado_instituicao == 0)
            <button class="btn btn-link p-0 text-decoration-none" onclick="abrirModalVerficar()">
              <h5 class="m-0">Pedido de verificação <i class='bx bxs-institution'></i></h5>
            </button>
            @endif
          </div>
        </div>
        <div class="buttonSair mt-3 mt-md-0">
          @if($usuario->status_user == 1)
            <a href="/curseiAdm/desativarUsuarios/{{$usuario -> id}}" class="botaoSair">
              <i class="bi bi-power"></i> Desativar conta
            </a>
          @else
            <a href="/curseiAdm/ativarUsuarios/{{$usuario -> id}}" style="color: var(--verde);">
              <i class="bi bi-power"></i> Ativar conta
            </a>
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
                <p>Curteis</p>
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
            <i class='bx  bx-repeat'  ></i> 
              <div class="textoEstati">
                <span>{{ $quantidadeReposts }}</span>
                <p>Reposts</p>
              </div>
            </div>
          </div>

          <div class="informacoes-container">
        
            <div class="painelInformacoes">
              <div class="d-flex justify-content-between align-items-center botoesInfo">
                <div class="d-flex align-items-center">
                  <i class="bi bi-info-circle fs-5 me-2"></i>
                  <h3 class="mb-0">Informações</h3>
                </div>
                <button onclick="abrirModalAlter()" class="botaoEdicao">
                  <i class="bi bi-pencil-square fs-5"></i>
                </button>
              </div>

              <p><strong>ID:</strong> {{ $usuario->id }} </p>
              <p><strong>Nome:</strong> {{ $usuario->nome_user }} </p>
              <p><strong>Email:</strong> {{ $usuario->email_user }} </p>
              <p><strong>Data de registro:</strong> {{ $instituicao->created_at }} </p>
              <p><strong>Ultima alteração:</strong> {{ $instituicao->updated_at }} </p>
              <p><strong>Ultima postagem:</strong> </p>
              <p><strong>Status da conta:</strong> 
                <span style="color: {{ $usuario->status_user == 1 ? 'var(--verde)' : 'var(--vermelho)' }};">
                  {{ $usuario->status_user == 1 ? 'Ativo' : 'Desativado' }}
                </span>
              </p>
            </div>

         
            <div class="painelInformacoes">
              <div class="d-flex justify-content-between align-items-center botoesInfo">
                <div class="d-flex align-items-center">
                  <i class="bi bi-telephone fs-5 me-2"></i>
                  <h3 class="mb-0">Endereço e Contato</h3>
                </div>
                <button onclick="abrirModalAlterInfo()" class="botaoEdicao">
                  <i class="bi bi-pencil-square fs-5"></i>
                </button>
              </div>

              <p><strong>CNPJ:</strong> {{ $instituicao->cnpj_instituicao }} </p>
              <p><strong>Contato:</strong> </p>
              <p><strong>CEP:</strong> {{ $instituicao->cep_instituicao }} </p>
              <p><strong>Endereço:</strong> {{ $instituicao->logradouro_instituicao }} </p>
              <p><strong>Número:</strong> {{ $instituicao->num_logradouro_instituicao }} </p>
              <p><strong>Bairro:</strong> {{ $instituicao->bairro_instituicao }} </p>
              <p><strong>Cidade:</strong> {{ $instituicao->cidade_instituicao }} </p>
              <p><strong>Estado:</strong> {{ $instituicao->estado_instituicao }} </p>
            </div>
          </div>
        </div>

      
        <div class="painelInformacoes grafico">
          <div class="grafico-box">
            <h3><i class="bi bi-bar-chart"></i> Visualização por mês</h3>
            <h2 class="total-views">904.223</h2>
            <p class="sub-text">Total views</p>
            <canvas id="chartMes"></canvas>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Modal Editar Informações -->
  <div class="container-fluid container-modal" id="contmodal" onclick="fecharModal(event)">
  <div class="modal-perfil" id="modal-perfil">
    <div class="titulo-modal">
      <i class="bi bi-person-gear"></i> Editar conta do usuário
    </div>

    <form action="{{ route('instituicao.atualizarDados', $usuario->id) }}" method="POST" enctype="multipart/form-data" id="form-editar-usuario">
      @csrf
      @method('PUT')
      <div class="topo-modal">
        <div class="banner-modal">
          <img src="{{ asset('img/user/bannerPerfil/' . ($usuario->banner_user ?? 'default-banner.jpg')) }}" alt="Banner" id="banner-preview">
        </div>
        <div class="abaixo-do-banner">
          <div class="img-perfil-modal">
            <img src="{{ asset('img/user/fotoPerfil/' . ($usuario->img_user ?? 'default-profile.jpg')) }}" alt="Foto de perfil" id="foto-preview">
          </div>
          <div class="botoes-alter-modal">
            <label for="foto-upload" class="upload-label">Alterar foto de perfil</label>
            <input type="file" id="foto-upload" class="upload-input" name="foto" accept="image/jpeg,image/png,image/jpg,image/gif">

            <label for="banner-upload" class="upload-label">Alterar foto do banner</label>
            <input type="file" id="banner-upload" class="upload-input" name="banner" accept="image/jpeg,image/png,image/jpg,image/gif">
          </div>
        </div>
      </div>
      <div class="inputs-modal">
        <p class="titulo-inputs"><i class='bx bx-info-circle'></i> Informações</p>
        <div class="lista-de-inputs">
          <div class="input-modal-container">
            <label for="nome">Nome</label>
            <input type="text" name="nome" value="{{ old('nome', $usuario->nome_user) }}" required>
          </div>
          <div class="input-modal-container">
            <label for="usuario">Usuário</label>
            <input type="text" name="usuario" value="{{ old('usuario', $usuario->arroba_user) }}" required>
          </div>
          <div class="input-modal-container">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email_user) }}" required>
          </div>
          <div class="input-modal-container">
            <label for="senha">Senha</label>
            <input type="password" name="senha" placeholder="Deixe em branco para não alterar">
          </div>
        </div>
      </div>
      <div class="botoes-salva-cancelar">
        <button type="button" onclick="fecharModal(event)">Cancelar</button>
        <button type="submit" class="salvar">Salvar</button>
      </div>
    </form>
  </div>
</div>



  <!-- Modal De atualizar os dados de endereco -->
<div class="container-fluid container-modal" id="contmodalInfo" onclick="fecharModalInfo(event)">
  <div class="modal-perfil" id="modal-perfil-perfil">
    <div class="titulo-modal">
      <i class="bi bi-geo-alt"></i> Atualizar dados da instituição
    </div>

    <form action="{{ route('instituicao.atualizarEndereco', ['id' => $usuario->id]) }}" method="POST" id="form-endereco">
      @csrf
      @method('PUT')
      <div class="inputs-modal">
        <p class="titulo-inputs"><i class='bx bx-location-plus'></i> Endereço</p>
        <div class="lista-de-inputs">
       
          <div class="input-modal-container">
            <label for="cep">CEP</label>
            <input type="text" name="cep" id="cep" maxlength="9" 
                   value="{{ $instituicao->cep_instituicao }}"
                   pattern="\d{5}-\d{3}" 
                   title="Formato: 12345-678"
                   required>
          </div>
          
       
          <div class="input-modal-container">
            <label for="endereco">Endereço</label>
            <input type="text" name="endereco" id="endereco" 
                   value="{{ $instituicao->logradouro_instituicao }}"
                   maxlength="100" required>
          </div>
          
     
          <div class="input-modal-container">
            <label for="numero">Número</label>
            <input type="text" name="numero" id="numero" 
                   value="{{ $instituicao->num_logradouro_instituicao }}"
                   maxlength="10" required>
          </div>
          

          <div class="input-modal-container">
            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro" 
                   value="{{ $instituicao->bairro_instituicao }}"
                   maxlength="50" required>
          </div>
          

          <div class="input-modal-container">
            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade" 
                   value="{{ $instituicao->cidade_instituicao }}"
                   maxlength="50" required>
          </div>
          

          <div class="input-modal-container">
            <label for="estado">Estado (Sigla)</label>
            <input type="text" name="estado" id="estado" 
                   value="{{ $instituicao->estado_instituicao }}"
                   maxlength="2" minlength="2"
                   pattern="[A-Za-z]{2}" 
                   title="Digite a sigla com 2 letras"
                   required>
          </div>
        </div>
      </div>
      <div class="botoes-salva-cancelar">
        <button type="button" onclick="fecharModalInfo(event)">Cancelar</button>
        <button type="submit" class="salvar">Salvar</button>
      </div>
    </form>
  </div>
</div>

  <!-- Modal Verificação -->
  <div class="cont-modal-verificar" id="modalVerificar" onclick="fecharModalVerificar(event)">
    <div class="modal-verificar">
      <h2><i class='bx bxs-institution'></i> Verificar Instituição</h2>
      <p>Esse usuário solicitou a conversão da sua conta para uma conta de instituição.</p>
      <div>
        <a id="recusar" href="/curseiAdm/verificarInts/{{$usuario->id}}/recusar">Recusar</a>
        <a href="/curseiAdm/verificarInts/{{$usuario->id}}/aprovar">Aceitar</a>
      </div>
    </div>
  </div>

  <script src="{{asset('js/abrirModalUser.js')}}"></script>
  <script src="{{asset('js/abrirModalInfo.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  

</body>
</html>