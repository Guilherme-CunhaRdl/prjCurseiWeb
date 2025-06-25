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
        <link rel="stylesheet" href="{{ asset('css/modalEngajamentos.css') }}">


</head>

<body>

    @include('area-instituicao.componentes.sidebar')

    <main>
            @include('area-instituicao.componentes.navbar', [
            'navbarIcon' => 'bx-image',
            'titulo' => 'Posts'
        ])

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
                            <p class="numero">{{$mediaCompartilhamento }} <i class='bx bx-share'></i></p>
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
            {{ $area->area_post }} ({{ $area->total }})
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


        @include('area-instituicao.componentes.modal-Impulsionar')
        @include('area-instituicao.componentes.modal-engajamentos')


    <script>
    </script>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/postsInstituicao/ModalverPost.js') }}"></script>
<script src="{{ asset('js/postsInstituicao/postsInstituicao.js') }}"></script>
<script src="{{ asset('js/postsInstituicao/modalCriarPosts.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/locale/pt-br.js"></script>
    <script src="{{ asset('js/modaisEngajamentos.js') }}"></script>


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

    @include('area-instituicao.componentes.modal-notificacao')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>