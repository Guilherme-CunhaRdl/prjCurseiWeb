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
<div class="novoPostmodalCont" id="novoPostmodalCont">
  <div class="novoPostModal " id="novoPostModal">
    <div class="topo">
      <p>Novo Post</p>
      <i class="bx bx-x" onclick="fecharModal()"></i>
    </div>
    <div class="tab">
      <button type="button" class="tab-ativo" id="tabPost">Post</button>
      <button type="button" id="tabEvento">Evento</button>
    </div>
    <form id="postForm">
      <div class="usuario">
        <div class="contImg">
          <img src="https://i.redd.it/6bn647ynsg9e1.jpeg" alt="" />
        </div>
        <div class="infouser">
          <p class="nome">Itau intitui</p>
          <p class="arroba">@itau</p>
        </div>
      </div>
      <div class="conteudoCont">
        <textarea placeholder="Digite o que aconteceu hoje..." name="descricaoPost" id="descricaoPost"></textarea>
        <div class="conteudo-img" id="conteudo-img">
          <img src="" alt="" id="imgPost" />
        </div>
      </div>
      <i class='bx bx-calendar-alt' id="buttonOpenModalDataPost"></i>
      <div class="rodape">
        <div>
          <button type="button" class="add" id="buttonOpenModalLinkPost" style="display: none;">
            <i class='bx bx-link'></i>
            <p>Adicionar Link</p>
          </button>
          <button type="button" class="add">
            <i class='bx bx-image-plus'></i>
            <label for="imgPostinput" style="cursor: pointer;">Adicionar imagem</label>
            <input type="file" style="display: none;" name="img" id="imgPostinput">
          </button>
        </div>
        <div class="cpb">
          <button type="button" class="cancelar" onclick="fecharModal()">
            Cancelar
          </button>
          <button type="button" class="postar" onclick="postarPost()">
            postar
          </button>
        </div>
      </div>
      <input type="hidden" name="link" id="linkInput">
      <input type="hidden" name="data" id="dataInput">
      <input type="hidden" name="hora" id="horaInput">

    </form>
    <form id="evento">
      <div class="topo-evento">
        <div class="capa_cont">
          <img src="" alt="" id="previewCapa">
          <label for="inputcapa">
            <i class='bx bx-image-plus'></i>
            <p>Adicione uma capa</p>
          </label>
          <input type="file" id="inputcapa" style="display: none;" name="img">
        </div>
        <div class="inputData">
          <div>
            <label for="">data inicio</label>
            <input type="date" placeholder="" name="inicio">
            <input type="time" placeholder="" class="horas" name="hinicio">
          </div>
          <div>
            <label for="">data término</label>
            <input type="date" placeholder="" name="fim">
            <input type="time" placeholder="" class="horas" name="hfim">
          </div>
        </div>
      </div>
      <div class="infosEvento">
        <label for="">Título </label>
        <div class="inputEventoCont">
          <img src="Icone_Logo_Cursei_Preta.png" alt="">
          <input type="text" placeholder="Escolha o título do seu evento " name="tituloEvento">
        </div>
        <label for="">Link</label>
        <div class="inputEventoCont">
          <i class='bx bx-link'></i>
          <input type="url" placeholder="Sua url aqui" name="link">
        </div>
        <label for="">data inicio</label>
        <textarea placeholder="Descreva seu evento" name="descEvento"></textarea>
      </div>
      <div class="rodape" style="justify-content: end;">
    
        <div class="cpb">
          <button type="button" class="cancelar" onclick="fecharModal()">
            Cancelar
          </button>
          <button type="button" class="postar" onclick="postarEvento()"> 
            postar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
 <div class="modalLinkPost" id="modalLinkPost">
        <div class="modalLinkPostContent">
            <h4 style="text-align: center;">Adicionar link no post</h4>
            <div class="modalLinkPostInputGroup">
                <label for="inputUrlLinkPost">URL</label>
                <input type="text" id="inputUrlLinkPost" placeholder="Cole ou digite a URL aqui">
            </div>
           
            <div style="width: 100%;display: flex;justify-content: center;">
                          <button id="buttonAddLinkPost">Adicionar</button>
            </div>
        </div>
    </div>

    <div class="modalLinkPost" id="modalDataPost">
        <div class="modalLinkPostContent">
            <h4 style="text-align: center;">Agendar Postagem</h4>
            <div class="modalLinkPostInputGroup">
                <label for="inputUrlLinkPost">Data e hora</label>
                <div style="display: flex;justify-content: space-evenly;">
                <input type="date" id="inputdataPost"  style="width:45%;">
                <input type="time" id="inputHoraPost"  style="width: 45%;">
                </div>
            </div>
           
            <div style="width: 100%;display: flex;justify-content: center;">
                          <button type="button" id="buttonAddDataPost">Agendar</button>
            </div>
        </div>
    </div>
    <script>
        const idInst = @json($instID);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/postsInstituicao.js') }}"></script>

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