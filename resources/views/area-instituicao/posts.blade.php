<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">


    @include('area-instituicao.componentes.padrao')
    <link rel="stylesheet" href="{{ asset('css/postsIntituicao.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modalVerPost.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modalImpulsionar.css') }}">


</head>

<body>
    @include('area-instituicao.componentes.sidebar')


    <main>
        @include('area-instituicao.componentes.navbar', ['titulo' => 'Posts'])
        <div class="container-fluid cont">
            <div class="esquerda">
                <div class="lista-dados-topo">
                    <div class="card-dados">
                        <i class='bx bx-image'></i>
                        <div class="dados-card-dados">
                            <p class="numero">{{ $postCount }}</p>
                            <p>Posts</p>
                        </div>
                    </div>
                    <div class="card-dados">
                        <i class='bx bx-repeat'></i>
                        <div class="dados-card-dados">
                            <p class="numero">{{ $repostsCount }}</p>
                            <p>Reposts</p>
                        </div>
                    </div>
                    <div class="card-dados">
                        <i class='bxr  bx-education'></i>
                        <div class="dados-card-dados">
                            <p class="numero">{{ $eventoCount }}</p>
                            <p>Eventos</p>
                        </div>
                    </div>
                </div>
                <div class="topo-catalogo">
                    <div class="">
                        <div class="inputCont">
                            <input type="text" placeholder="Pesquise pela descrição do post" id="pesquisarPosts">
                            <i class='bx  bx-search'></i>
                        </div>
                    </div>
                    <button onclick="abrirModal()">
                        <p>Novo posts</p>
                        <i class='bx bx-plus'></i>
                    </button>
                </div>

                <div class="lista-catalogo-card" id="listaPosts"></div>
            </div>

            <div class="direita">
                <div class="card-direita engajamento-cont">
                    <p class="titulo-card">
                        Medias de engajamento
                    </p>
                    <div>
                        <div class="dados-engajamento">
                            <p class="numero">{{  $mediaCurtidas}} <i class='bx bx-heart'></i></p>
                            <p>Curtidas</p>
                        </div>
                        <div class="dados-engajamento">
                            <p class="numero">{{$mediaComentarios}} <i class='bx bx-message-circle'></i></p>
                            <p>Comentarios</p>
                        </div>
                        <div class="dados-engajamento">
                            <p class="numero">{{$mediaReposts}} <i class='bx bx-repeat'></i></p>
                            <p>Reposts</p>
                        </div>
                        <div class="dados-engajamento">
                            <p class="numero">0 <i class='bx bx-share'></i></p>
                            <p>Compartilhamentos</p>
                        </div>
                    </div>
                </div>
                @php
    $cores = ['#b05fc0', '#ffa07a', '#87cefa', '#32cd32'];
@endphp

<!-- Card com gráfico e legenda -->
<div class="card-direita areaposts-cont">
    <p class="titulo-card">Área dos posts</p>
    <div class="cont-grafico">
        <canvas id="grafico"></canvas>
        <div>
            <p>{{ $porcentagemAreaPrincipal }}%</p>
            <p class="area">{{ $areaPrincipal }}</p>
        </div>
    </div>
 <div class="areas-lista">
    @foreach ($postsPorArea as $index => $area)
        <div>
            <span style="background: {{ $cores[$index % count($cores)] }};"></span>
            {{ $area->area_post }}
        </div>
    @endforeach
     </div>
</div>
                <div class="card-direita diassemana-cont">
                    <p class="titulo-card">
                        Posts por dia da semana
                    </p>
                    <div class="cont-grafico">
                        <div class="canvas"></div>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <!--------------------------------------- modal post ------------------------------------------>
    @include('area-instituicao.componentes.modais-post')

 <div class="contModalPostView" id="viewPost" >
    <div class="modalPotsView" id="modalPotsView" >
      <div class="topo">
        <p>Seu Post</p>
        <i class="bx bx-x" id="iconeX" onclick="fecharModalVerPost()"></i>
        <p id="editandoP">Editando</p>
      </div>
      <form class="conteudoPost" id="postUpdateNormal" >
        <textarea name="descricaoPost" id="descPostModal" disabled>Itaú é doidera cara, desde criancinha to usando ele cara, sério. </textarea>
        <div class="imgConteudo" id="imgModalVerPost">
          <img src="" alt="" id="imgPostVisualizacao">
          <label for="imgUpdate" id="labelImgUpdate">
             <i class='bx bx-image'></i>
            <p>Alterar imagem</p>
          </label>
          <input type="file" accept="image/*" name="img" id="imgUpdate" >
        </div>
</form>
      <form class="evento" id="eventoUpdate">
         <div class="topo-evento">
        <div class="capa_cont">
          <img src="" alt="" id="previewCapaUpdate">
          <label for="inputcapaUpdate" id="labelAlterCapa" style="display: none;">
            <i class='bx bx-image-plus'></i>
            <p>Alterar capa</p>
          </label>
          <input type="file" id="inputcapaUpdate" style="display: none;" name="img">
        </div>
        <div class="inputData">
          <div>
             <label for="">data inicio</label>
                <div class="d-flex">
                      <input type="date" placeholder="" name="inicio" id="inicioUpdate" disabled>
  <input type="time" placeholder="" class="hinicio" name="hinicio" id="hinicioUpdate" disabled>
                </div>
          </div>
          <div>
  <label for="">data término</label>
    <div class="d-flex">
          <input type="date" placeholder="" name="fim" id="fimUpdate" disabled>
  <input type="time" placeholder="" class="hfim" name="hfim" id="hfimUpdate" disabled>
    </div>
</div>
        </div>
      </div>
      <div class="infosEvento">
         <label for="">Título </label>
  <div class="inputEventoCont">
    <img src="Icone_Logo_Cursei_Preta.png" alt="">
    <input type="text" placeholder="Escolha o título do seu evento " name="tituloEvento" id="tituloEventoUpdate" disabled>
        </div>
        <label for="">Link</label>
        <div class="inputEventoCont">
          <i class='bx bx-link'></i>
    <input type="url" placeholder="Sua url aqui" name="link" id="linkUpdate" disabled>
  
        </div>
        <label for="">Descrição</label>
  <textarea placeholder="Descreva seu evento" name="descEvento" id="descEventoUpdate" disabled></textarea>
      </div>
    <input type="hidden" name="idEvento" id="idEvendoInputHiddenUpdate">
</form>
        <div class="rodape" id="normal">
          <div class="action">
            <button type="button" onclick="ativarEdicao()"><i class='bx bx-edit'></i>Editar</button>
            <button type="button" id="openModalBtn"><i class='bx bx-star'></i>Impulsionar</button>
            <button type="button" id="desativar" onclick="abrirModalDesativar()"><i class='bx bx-backspace'></i>Desativar</button>
          </div>
          <div class="button">
             <button  type="button" onclick="fecharModalVerPost()">Sair</button>
          </div>
        </div>
          <div class="rodape" id="editando">
          <div class="action" id="actions">
            <button  type="button" class="botoes" id="addLinkUpdateButton"><i class='bx bx-link '></i>Adicionar link</button>
            <label  class="botoes" for="imgUpdate" id="addImgLabelVerModal"><i class='bx bx-image-plus'></i>Adicionar imagem</label>
            
          </div>
          <div class="button">
             <button type="button" class="cancelar" onclick="desativarEdicao()">Cancelar</button>
            <button type="button" onclick="salvar()">Salvar</button>

          </div>
        </div>
        <input type="hidden" name="link" id="linkUpdate">
</div>
  </div>
        @include('area-instituicao.componentes.modal-Impulsionar')


    <script>
        const idInst = @json($instID);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/postsInstituicao/ModalverPost.js') }}"></script>
    <script src="{{ asset('js/postsInstituicao/postsInstituicao.js') }}"></script>
    <script src="{{ asset('js/postsInstituicao/modalCriarPosts.js') }}"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <script>
    const labels = @json($postsPorArea->pluck('area_post'));
    const data = @json($postsPorArea->pluck('total'));
    const colors = @json($cores);

    const ctx = document.getElementById('grafico');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#b05fc0', '#ffa07a', '#87cefa', '#32cd32'],
                borderWidth: 0,
            }]
        },
        options: {
            rotation: -90,
            circumference: 180,
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            }
        }
    });
</script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>