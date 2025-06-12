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
                            <p class="numero">40</p>
                            <p>Posts</p>
                        </div>
                    </div>
                    <div class="card-dados">
                        <i class='bx bx-repeat'></i>
                        <div class="dados-card-dados">
                            <p class="numero">3</p>
                            <p>Reposts</p>
                        </div>
                    </div>
                    <div class="card-dados">
                       <i class='bxr  bx-education'  ></i> 
                        <div class="dados-card-dados">
                            <p class="numero">5</p>
                            <p>Eventos</p>
                        </div>
                    </div>
                </div>
                <div class="topo-catalogo">
                    <div class="">
                        <div class="inputCont">
                            <input type="text" placeholder="Pesquise pela descrição do post">
                            <i class='bx  bx-search'></i>
                        </div>
                    </div>
                    <button>
                        <p>Novo posts</p>
                        <i class='bx bx-plus'></i>
                    </button>
                </div>
              <div class="lista-catalogo-card">
                    <div class="card-conteudo">
                       <div class="cont-desc-card">
                         <p>Venha para a etec de guianasses ,temos muitas opções de cursos</p>
                       </div>
                        <div class="img">
                            <img src="https://etecsantosdumont.com.br/wp-content/uploads/2023/03/335588264_613348350805960_3933893113793637074_n.jpg" alt="">
                        </div>
                        <div class="infos-conteudo">
                            <div class="info">
                                <i class='bx bx-heart'></i>
                                <p>22</p>
                            </div>
                            <div class="info">
                                <i class='bx  bx-message-circle'></i>
                                <p>6</p>
                            </div>
                            <div class="info">
                                <i class='bx bx-repeat-alt'></i>
                                <p>3</p>
                            </div>

                        </div>

                    </div>
                       <div class="card-conteudo">
                       <div class="cont-desc-card">
                         <p>Inscrições abertas para etec de guianasses!! corra!!</p>
                       </div>
                        <div class="img">
                            <img src="https://bkpsitecpsnew.blob.core.windows.net/uploadsitecps/sites/48/2025/05/2025_posts_rede_sociais__card01_vestibulinho_2025_02sem_feed_cps_02-1-scaled.png" alt="">
                        </div>
                        <div class="infos-conteudo">
                            <div class="info">
                                <i class='bx bx-heart'></i>
                                <p>32</p>
                            </div>
                            <div class="info">
                                <i class='bx  bx-message-circle'></i>
                                <p>12</p>
                            </div>
                            <div class="info">
                                <i class='bx bx-repeat-alt'></i>
                                <p>7</p>
                            </div>

                        </div>

                    </div>
                           <div class="card-conteudo">
                       <div class="cont-desc-card">
                         <p>Inscrições para processo seletivo do primeiro semestre de 2025 nas Etecs estão abertas — Prefeitura de São Vicente</p>
                       </div>
                        <div class="img">
                            <img src="https://etecsantosdumont.com.br/wp-content/uploads/2024/05/Vestibulinho-20242.jpg" alt="">
                        </div>
                        <div class="infos-conteudo">
                            <div class="info">
                                <i class='bx bx-heart'></i>
                                <p>9</p>
                            </div>
                            <div class="info">
                                <i class='bx  bx-message-circle'></i>
                                <p>3</p>
                            </div>
                            <div class="info">
                                <i class='bx bx-repeat-alt'></i>
                                <p>0</p>
                            </div>

                        </div>

                    </div>
                    </div>
            </div>
            <div class="direita">
                <div class="card-direita engajamento-cont">
                    <p class="titulo-card">
                        Medias de engajamento
                    </p>
                    <div>
                        <div class="dados-engajamento">
                            <p class="numero">40 <i class='bx bx-heart'></i></p>
                            <p>Curtidas</p>
                        </div>
                        <div class="dados-engajamento">
                            <p class="numero">40 <i class='bx bx-message-circle'></i></p>
                            <p>Comentarios</p>
                        </div>
                        <div class="dados-engajamento">
                            <p class="numero">40 <i class='bx bx-repeat'></i></p>
                            <p>Reposts</p>
                        </div>
                        <div class="dados-engajamento">
                            <p class="numero">40 <i class='bx bx-share'></i></p>
                            <p >Compartilhamentos</p>
                        </div>
                    </div>
                </div>
                <div class="card-direita areaposts-cont">
                    <p class="titulo-card">
                        Área dos posts
                    </p>
                    <div class="cont-grafico">
                        <canvas id="grafico"></canvas>
                        <div>
                            <p>40%</p>
                            <p class="area">Tecnologia</p>
                        </div>
                    </div>
                    <div class="areas-lista">
                        <div><span style="background: #b05fc0;"></span> Tecnologia</div>
                        <div><span style="background: var(--inst);"></span> Saúde</div>
                         <div><span style="background: var(--sidebar);"></span> Nutrição</div>
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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('grafico');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Tecnologia', 'Saúde', 'Nutrição'],
                datasets: [{
                    data: [40, 30, 30],
                    backgroundColor: ['#b05fc0', '#51b8f3', '#ff8c00'],
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