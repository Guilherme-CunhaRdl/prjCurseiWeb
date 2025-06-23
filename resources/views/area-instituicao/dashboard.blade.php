
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">


    <link rel="stylesheet" href="{{ asset('css/dashboardInst.css') }}">
            @include('area-instituicao.componentes.padrao')

</head>

<body>
        @include('area-instituicao.componentes.sidebar')

    <main>
@include('area-instituicao.componentes.navbar', ['titulo' => 'Dashboard'])

        <div class="container-fluid cont">
            <div class="esquerda">
                <div class="TopDados">
                    <div class="cardDados">
                        <i class='bx bx-user'></i>
                        <div>
                            <p class="numero">{{$todosSeguidores}}</p>
                            <p>Seguidores</p>
                        </div>
                    </div>
                    <div class="cardDados">
                        <i class='bx bx-image'></i>
                        <div>
                            <p class="numero">{{$todosPosts}}</p>
                            <p>Posts</p>
                        </div>
                    </div>
                    <div class="cardDados">
                        <i class='bx bxs-videos'></i>
                        <div>
                            <p class="numero">{{$todosCurteis}}</p>
                            <p>Curteis</p>
                        </div>
                    </div>
                    <div class="cardDados">
                        <i class='bx bx-heart'></i>
                        <div>
                            <p class="numero">{{$curtidasConteudo}}</p>
                            <p>Curtidas</p>
                        </div>
                    </div>
                    <div class="cardDados">
                        <i class='bx bxs-repeat'></i>
                        <div>
                            <p class="numero">{{$quantidadePostsRepostados}}</p>
                            <p>Reposts</p>
                        </div>
                    </div>
                    <div class="cardDados">
                        <i class='bx bxs-share'></i>
                        <div>
                            <p class="numero">26</p>
                            <p>Compartilhados</p>
                        </div>
                    </div>
                </div>
                <div class="graficos">

                    <div class="grafico_pizza">
                        <p>Interações por período</p>
                        <div class="pizza">
                            <canvas id="pizza"></canvas>
                        </div>
                        <div class="infos">
                            <div class="info">
                                <div>
                                    <div class="bola manha">
                                    </div>
                                    <p>Manhã</p>
                                </div>
                                <span>{{$porcentagemManha}}</span>
                            </div>
                                <div class="info">
                                <div>
                                    <div class="bola tarde">
                                    </div>
                                    <p>Tarde</p>
                                </div>
                                <span>{{$porcentagemTarde}}</span>
                            </div>
                            <div class="info">
                                <div>
                                    <div class="bola noite">
                                    </div>
                                    <p>Noite</p>
                                </div>
                                <span>{{$porcentagemNoite}}</span>
                            </div>



                        </div>

                    </div>
                    <div class="grafico_pizza">
                        <p>Interesses do seguidores</p>
                        <div class="pizza">
                            <canvas id="pizza2"></canvas>
                        </div>
                        <div class="infos">
                            <div class="info2">
                                <div>
                                    <div class="bola manha">
                                    </div>
                                    <p>{{$top3AreasInteresse[0]['area']??'Ainda não definido'}}</p>
                                </div>
                                <span>{{$top3AreasInteresse[0]['porcentagem'] ?? '0%'}}</span>
                            </div>
                            <div class="info2">
                                <div>
                                    <div class="bola manha">
                                    </div>
                                    <p>{{$top3AreasInteresse[1]['area']??'Ainda não definido'}}</p>
                                </div>
                                <span>{{$top3AreasInteresse[1]['porcentagem'] ?? '0%'}}</span>
                            </div>
                            <div class="info2">
                                <div>
                                    <div class="bola manha">
                                    </div>
                                    <p>{{$top3AreasInteresse[2]['area']??'Ainda não definido'}}</p>
                                </div>
                                <span>{{$top3AreasInteresse[2]['porcentagem'] ?? '0%'}}</span>
                            </div>
                            <div class="info2">
                                <div>
                                    <div class="bola noite">
                                    </div>
                                    <p>Outros</p>
                                </div>
                                <span>{{$outrasAreasPorcentagem}}</span>
                            </div>



                        </div>

                    </div>
                </div>
                <div class="engajamento">
                    <p>Engajamento</p>
                    <div class="grafico-linha">
                        <canvas id="graficoLinha"></canvas>
                    </div>
                </div>

            </div>
            <div class="direita">
                <div class="grafico-direita">
                    <p>Posts por dia na semana</p>
                    <div>
                        <canvas id="a"></canvas>
                    </div>
                </div>
                <div class="posts">
                    <div class="row   justify-content-between" >
                        <div class="col">
                        <p class="tipo-post">Post mais engajado</p>
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
                        </div>
                        <div class="col">
                               <p class="tipo-post">Post mais recente</p>
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>



        const pizza = document.getElementById('pizza')
        new Chart(pizza, {
            type: 'doughnut',
            data: {
                labels: ['Noite', 'Manhã', 'Tarde'],
                datasets: [{
                    data: [{{$interacoesNoite}}, {{$interacoesManha}}, {{$interacoesTarde}}],
                    backgroundColor: ['#1B242E', '#448FFF', '#be780e'],
                    borderWidth: 0,
                }]
            },
            options: {

                cutout: '50%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        const pizza2 = document.getElementById('pizza2')
        new Chart(pizza2, {
            type: 'doughnut',
            data: {
                labels: [@json($top3AreasInteresse[0]['area'] ?? 'Sem dados'), @json($top3AreasInteresse[1]['area'] ?? 'Sem dados'), @json($top3AreasInteresse[2]['area'] ?? 'Sem dados'), 'Outros'],
                datasets: [{
                    data: [{{$top3AreasInteresse[0]['valor']??0}}, {{$top3AreasInteresse[1]['valor']??0}}, {{$top3AreasInteresse[2]['valor']??0}}, {{$somaOutrasAreas??0}}],
                    backgroundColor: ['#616161', '#448FFF', '#BA68C8', '#FF8418'],
                    borderWidth: 0,
                }]
            },
            options: {
                cutout: '50%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        const ctx = document.getElementById('graficoLinha').getContext('2d');

        const graficoLinha = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ],
                datasets: [{

                    data: [120, 150, 180, 170, 200, 220, 210, 230, 250, 240, 260, 280],
                    borderColor: '#FF8418',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }

            }

        });
        const barra = document.getElementById("a")
        const stockChart = new Chart(barra, {
            type: 'bar',
            data: {
                labels: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                datasets: [{
                        label: 'Usuarios',
                        data: [5, 2, 5, 2, 4, 5, 5],
                        backgroundColor: getComputedStyle(root).getPropertyValue('--inst').trim(),
                        borderRadius: 2,
                        yAxisID: 'y',

                    },


                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        grid: {
                            display: false

                        }
                    }
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
