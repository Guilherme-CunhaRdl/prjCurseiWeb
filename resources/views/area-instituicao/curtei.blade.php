<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Curteis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">


    @include('area-instituicao.componentes.padrao')
    <link rel="stylesheet" href="{{ asset('css/curteiIntituicao.css') }}">

</head>

<body>
    @include('area-instituicao.componentes.sidebar')


    <main>
        @include('area-instituicao.componentes.navbar', [
        'navbarIcon' => 'bxs-videos',
        'titulo' => 'Posts'
        ])
        <div class="container-fluid cont">
            <div class="esquerda">
                <div class="lista-dados-topo">
                    <div class="card-dados">
                        <i class='bx bxs-videos'></i>
                        <div class="dados-card-dados">
                            <p class="numero">{{ $totalCurteis }}</p>
                            <p>Curteis</p>
                        </div>
                    </div>
                    <div class="card-dados">
                        <i class='bx bx-message-circle'></i>
                        <div class="dados-card-dados">
                            <p class="numero">{{ $totalComentarios }}</p>
                            <p>Comentarios</p>
                        </div>
                    </div>
                    <div class="card-dados">
                        <i class='bxr  bx-heart'></i>
                        <div class="dados-card-dados">
                            <p class="numero">{{ $totalCurtidas }}</p>
                            <p>Curtidas</p>
                        </div>
                    </div>
                </div>
                <div class="topo-catalogo">
                    <div class="">
                        <div class="inputCont">
                            <input type="text" placeholder="Pesquise pela descrição do curtei" id="pesquisarCurtei">
                            <i class='bx  bx-search'></i>
                        </div>
                    </div>
                    <button>
                        <p>Novo Curtei</p>
                        <i class='bx bx-plus'></i>
                    </button>
                </div>
                <div class="lista-catalogo-card" id="listaCurteis">


                </div>
            </div>
            <div class="direita">
                <div class="card-direita engajamento-cont">
                    <p class="titulo-card">
                        Medias de engajamento
                    </p>
                    <div>
                        <div class="dados-engajamento">
                            <p class="numero">{{ $mediaCurtidasPorCurtei }} <i class='bx bx-heart'></i></p>
                            <p>Curtidas</p>
                        </div>
                        <div class="dados-engajamento">
                            <p class="numero">{{ $mediaComentariosPorCurtei }} <i class='bx bx-message-circle'></i></p>
                            <p>Comentarios</p>
                        </div>
                    </div>
                </div>
                <div class="card-direita areaposts-cont">
                    <p class="titulo-card">Interesses de quem curti</p>

                    <div class="cont-grafico">
                        <canvas id="grafico"></canvas>

                        {{-- Centro do gráfico com % e nome --}}
                        <div>
                            <p>{{ $porcentagemMaisPresente }}%</p>
                            <p class="area">{{ ucfirst($interesseMaisPresente ?? 'Nenhum') }}</p>
                        </div>
                    </div>

                    {{-- Lista de interesses (cores dinâmicas) --}}
                    <div class="areas-lista">
                        @php
                        $cores = ['#b05fc0', '#51b8f3', '#ff8c00', '#00c896', '#fc636b', '#6f42c1'];
                        $index = 0;
                        @endphp

                        @foreach($interesses as $interesse => $total)
                        <div>
                            <span style="background: {{ $cores[$index % count($cores)] }}"></span>
                            {{ ucfirst($interesse) }} ({{ $total }})
                        </div>
                        @php $index++; @endphp
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

    <div class="contModalverCurtei" id="contModalverCurtei">
        <form class="modalCur" id="formUpdate">
            <div class="topo">
                <p>Seu curtei</p>
                <i class="bx bx-x" onclick="fecharCurtei()"></i>
                <p style="font-weight: 600;font: 19px;color: var(--inst); display: none;" id="editandoP">Editando</p>
            </div>
            <textarea disabled name="legenda_curtei"></textarea>
            <div style="padding-inline: 4%;">
                <div class="video">
                    <video controls width="600" src="" autoplay muted loop id="source">

                    </video>
                    <label for="inputVideoEdit" id="labelEditVideo">
                        <i class='bx  bx-pencil'></i>
                    </label>
                    <input type="file" id="inputVideoEdit" style="display: none;" accept="video/*" name="caminho_curtei">

                </div>
                <div id="imgModalVerPost">
                    <img src="" alt="" id="imgEditCurtei">
                    <label for="inputcapa">
                        <i class='bx bx-image-plus'></i>
                        <p>Altere a thumbnail</p>
                    </label>
                    <input type="file" id="inputcapa" style="display: none;" name="caminho_curtei_thumb" accept="image/*">
                </div>
            </div>
            <div class="rodape">
                <div>
                    <button type="button" onclick="ativarEdit()"><i class="bx bx-edit" id="editBtn"></i></button>
                    <button type="button"><i class="bx bx-backspace" id="backBtn" onclick="abrirModalDesativar()"></i></button>
                    <button type="button"><i class="bx bx-image" id="imgBtn" style="display: none;" onclick="editarThumb()"></i></button>
                    <button type="button"><i class="bx bx-video" id="videoBtn" style="display: none;" onclick="editarVideo()"></i></button>

                </div>
                <div style="display: flex;gap:20px">
                    <button type="button" class="sair" id="sairBtn" onclick="fecharCurtei()">Sair</button>
                    <button type="button" class="sair" style="display: none;" id="cancelarBtn" onclick="desativarEdit()">Cancelar</button>
                    <button type="button" class="sair" style="display: none;" id="salvaBtn" onclick="salvar()">Salvar</button>

                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        
        const labels = @json(array_keys($interesses));
        const data = @json(array_values($interesses));

        const ctx = document.getElementById('grafico');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#b05fc0', '#51b8f3', '#ff8c00', '#00c896', '#fc636b', '#6f42c1'],
                    borderWidth: 0,
                }]
            },
            options: {
                rotation: -90,
                circumference: 180,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
    @include('area-instituicao.componentes.modal-notificacao')
    <script src="{{ asset('js/curtei/puxarCurtei.js') }}"></script>
    <script src="{{ asset('js/curtei/modalVerCurtei.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>