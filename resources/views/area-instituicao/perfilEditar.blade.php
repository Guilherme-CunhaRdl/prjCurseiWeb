<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editando Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ url('css/perfilEditar.css') }}">
    <link rel="icon" href="{{ asset('img/Icone_Logo_Cursei_Preta.png') }}" type="image/x-icon" />
   @include('area-instituicao.componentes.padrao')
</head>
<body>
    <main class="container-fluid p-0">
        @include('area-instituicao.componentes.navbar', [
            'navbarIcon' => 'bx-user',
            'titulo' => 'Editar Perfil'
        ])
        <div class="col-12 flex-row d-flex">
            <!-- Coluna do formulário -->
            <div class="col-md-6 p-5">
                <div class="ps-5 col-10">
                    <div class="col-12">
                        <h1>Personalização de Página</h1>
                    </div>
                    <div class="col-12 d-flex flex-row my-3">
                        <div style="width: 90px">
                            <div class="div-img-alterar">
                                <img class="img-alterar img-fluid carregarImgPerfil" src="{{ asset("img/user/fotoPerfil/$user->img_user") }}" alt="">
                                <div class="conteudo-img-perfil">
                                    <i class="bi bi-camera"></i>
                                    <label for="imgPerfil" class="h-100 w-100 position-absolute"></label>
                                    <input type="file" accept="image/*" id="imgPerfil" class="d-none">
                                </div>
                            </div>
                        </div>
                        <div class="col-10 d-flex align-items-center">
                            <span class="span-foto-perfil">Foto de Perfil</span>
                        </div>
                    </div>

                    <div class="col-12 ps-2 my-2">
                        <span class="span-frase-banner">Imagem do banner</span>
                    </div>

                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <div class="div-img-banner">
                            <img class="img-banner img-fluid bannerPreview" src="{{ asset("img/user/bannerPerfil/$user->banner_user") }}" alt="">
                            <div class="conteudo-banner">
                                <i class="bi bi-camera"></i>
                                <label class="w-100 h-100 position-absolute" style="opacity: 0;" for="bannerImg">Clique Para Alterar Seu Banner!</label>
                                <input class="d-none" type="file" accept="image/*" id="bannerImg">
                            </div>
                        </div>
                    </div>

                    <div class="div-forms col-12">
                        <div class="col-12 d-flex flex-row my-3" style="height: 50px;">
                            <div class="col-3 d-flex align-items-center">
                                <span class="span-alterar">Nome</span>
                            </div>
                            <div class="col-9">
                                <input class="input-alterar" type="text" value="{{ $user->nome_user }}" id="input-nome">
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-row my-3">
                            <div class="col-3 d-flex align-items-center">
                                <span class="span-alterar">Descrição</span>
                            </div>
                            <div class="col-9">
                                <textarea rows="4" class="input-alterar" id="input-bio">{{ $user->bio_user }}</textarea>
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-row my-3" style="height: 50px;">
                            <div class="col-3 d-flex align-items-center">
                                <span class="span-alterar">Usuário</span>
                            </div>
                            <div class="col-9">
                                <input class="input-alterar" value="{{ $user->arroba_user }}" type="text" id="input-contato">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ps-2 mt-4">
                        <button class="botao-salvar" type="button">Salvar</button>
                        <button class="botao-cancelar" type="button" onclick="window.location.href='{{ url('curseiInstituicao/conta') }}'">Cancelar</button>
                    </div>
                </div>
            </div>
            <!-- Coluna do preview -->
            <div class="col-md-6 p-5" >
                <div class="col-12 p-4">
                    <h3 class="tit-preview">Preview</h3>
                    <div class="col-12">
                        <div class="box-preview-perfil" style="box-sizing: border-box; overflow-y:auto;">
                            <div class="col-12 position-relative">
                                <img class="banner-preview bannerPreview" src="{{ asset('img/img-instituicao/banners/banner.png') }}" alt="">
                                <div class="div-img-preview-perfil">
                                    <img class="img-preview-perfil carregarImgPerfil" src="{{ asset("img/user/fotoPerfil/$user->img_user") }}" alt="">
                                </div>
                            </div>
                            <div class="col-12 mt-3 d-flex justify-content-end">
                                <button class="button-editar-preview me-3">Editar Conta</button>
                            </div>
                            <div class="col-12 mt-3 ms-5">
                                <div class="d-flex flex-column">
                                    <span class="nome-usuario-preview" id="nome-user-preview">Etec de Itaquera</span>
                                    <div class="flex-row">
                                        <span class="arroba-usuario-preview">@</span><span class="arroba-usuario-preview" id="arroba-user-preview">etecitaquera</span>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p id="bio-user-preview">Mane fé filho, é suco de goiaba...</p>
                                </div>
                                <div>
                                    <span><b>{{ $seguidores }}</b> <span class="span-seguidores me-3">Seguidores</span></span>
                                    <span><b> {{ $seguidos }} </b> <span class="span-seguidores">Seguindo</span></span>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="botao-seguindo">Seguindo</button>
                                    <button class="botao-mensagem">Mensagem</button>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 mt-3 ms-5" style="overflow-y: auto;">
                                <!-- Exemplo de post preview -->
                                @foreach ($posts as $item)
                                    
                                <div class="col-12 my-3 mb-5" style="overflow-x: hidden;">
                                    <div class="col-12 d-flex flex-row ms-5 pt-2">
                                        <div class="box-post-perfil-preview col-1">
                                            <img src="{{ asset("img/user/fotoPerfil/$user->img_user") }}" alt="">
                                        </div>
                                        <div class="col-11">
                                            <div class="col-12 h-50 d-flex align-items-center">
                                                <span>{{ $user->nome_user}}</span>
                                                . {{ $item->created_at }}
                                            </div>
                                            <div class="col-12 h-50">
                                                <span>@ {{ $user->arroba_user }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 ms-5">
                                        <p>{{ $item->descricao_post }}</p>
                                        <div class="box-post-conteudo-preview" style="overflow-x: hidden;">
                                            <img src="{{ asset("img/user/imgPosts/$item->conteudo_post") }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                                               @endforeach

                                <!-- Fim exemplo post -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

  <div class="ContmodalTema" id="ContmodalTema" style="z-index: 999;">
      <div class="modalTema" id="modalTema">
    <i class="bx bx-x" onclick="fecharModalTema()" style="cursor: pointer;margin: 0px;width: 100%;text-align: end;padding-right: 20px;font-size: 30px;"></i>
          <p class="titulotema">
              Personalize sua cursei
          </p>

          <div style="padding-inline: 5%;">
              <p>Tema:</p>
              <div class="buttonsTemas">
                  <button onclick="alterarTema('claro')" id="sun">
                      <i class='bx  bx-sun'></i>
                  </button>
                  <button id="moon" onclick="alterarTema('escuro')">
                      <i class='bx  bx-moon'></i>
                  </button>
              </div>
          </div>
          <div class="cores">
              <p>Cor Principal:</p>
              <div class="listaCores" id="listaCores">

                  <button onclick="trocarCorInst(this,'vermelho')" style="background-color:#e90013;">

                  </button>

                  <button onclick="trocarCorInst(this,'azul')" style="background-color: #448FFF;">

                  </button>

                  <button onclick="trocarCorInst(this,'verde')" style="background-color: #2ECC71;">

                  </button>

                  <button onclick="trocarCorInst(this,'amarelo')" style="background-color: #F1C40F;">

                  </button>

                  <button onclick="trocarCorInst(this,'laranja')" style="background-color: #FF8418;">

                  </button>

                  <button onclick="trocarCorInst(this,'roxo')" style="background-color: #6b00cf;">

                  </button>

                  <button onclick="trocarCorInst(this,'rosa')" style="background-color: #E91E63;">

                  </button>

                  <button onclick="trocarCorInst(this,'preto')" style="background-color: #2F2F2F;">

                  </button>

                  <button onclick="trocarCorInst(this,'verdeAqua')" style="background-color: #05A4B6;">

                  </button>

                  <button onclick="trocarCorInst(this,'azulEscuro')" style="background-color: #10009D;">

                  </button>


              </div>
          </div>
      </div>
  </div>
  <script>
    if (localStorage.getItem('temaInst') == 'claro') {
        document.getElementById('sun').classList.add('buttontemaAtivo')
    }else{
        document.getElementById('moon').classList.add('buttontemaAtivo')
    }
     document.getElementById('sun').addEventListener('click', () => {
        document.getElementById('sun').classList.add('buttontemaAtivo')
        document.getElementById('moon').classList.remove('buttontemaAtivo')
     })
        document.getElementById('moon').addEventListener('click', () => {
        document.getElementById('sun').classList.remove('buttontemaAtivo')
        document.getElementById('moon').classList.add('buttontemaAtivo')
     })
  </script>

    <script>
        // Preview da imagem de perfil
        document.getElementById('imgPerfil').addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.querySelectorAll('.carregarImgPerfil').forEach(img => img.src = e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
        // Preview do banner
        document.getElementById('bannerImg').addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.querySelectorAll('.bannerPreview').forEach(img => img.src = e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
        // Preview dos campos texto
        document.getElementById('input-nome').addEventListener('input', function () {
            document.getElementById('nome-user-preview').textContent = this.value;
        });
        document.getElementById('input-contato').addEventListener('input', function () {
            document.getElementById('arroba-user-preview').textContent = this.value;
        });
        document.getElementById('input-bio').addEventListener('input', function () {
            document.getElementById('bio-user-preview').textContent = this.value;
        });
        // Preencher preview inicial
        document.getElementById('nome-user-preview').textContent = document.getElementById('input-nome').value;
        document.getElementById('arroba-user-preview').textContent = document.getElementById('input-contato').value;
        document.getElementById('bio-user-preview').textContent = document.getElementById('input-bio').value;
    </script>
   @include('area-instituicao.componentes.modal-notificacao')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
