<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @include('area-adm.componentes.links-base')

    <link rel="stylesheet" href="{{asset('css/postsAdm.css')}}">
</head>

<body>
    @include('area-adm.componentes.sidebar')
    <main>
        <div class="container-fluid cont">
            <div class="tituloPag">
                <p>Posts</p>
            </div>
            <div class="graficos-infos">
                <div class="esquerda">
                    <div class="info_cards">
                        <div>
                            <div class="icone">
                                <i class='bx bx-image-alt'></i>
                            </div>
                            <div class="infos">
                                <p>{{$totalPosts}}</p>
                                <p>Posts</p>
                            </div>
                        </div>
                        <div id="meio">
                            <div class="icone">
                                <i class='bx bx-heart'></i>
                            </div>
                            <div class="infos">
                                <p>{{$totalCurtidas}}</p>
                                <p>Curtidas</p>
                            </div>
                        </div>
                        <div>
                            <div class="icone">
                                <i class='bx bx-download'></i>
                            </div>
                            <div class="infos">
                                <p>0</p>
                                <p>Downloads</p>
                            </div>
                        </div>
                    </div>
                    <div class="graficos">
                        <div class="grafico_pizza" id="graficop1">
                            <p>Posts por tipo de conta</p>
                            <div class="pizza">
                                <canvas id="pizzaContas"></canvas>
                            </div>
                            <div class="infos">
                                <div class="info">
                                    <div>
                                        <div class="bola user">
                                        </div>
                                        <p>Usuarios</p>
                                    </div>
                                    <span>{{$porcentagemUser}}%</span>
                                </div>
                                <div class="info">
                                    <div>
                                        <div class="bola inst">
                                        </div>
                                        <p>Instituições</p>
                                    </div>
                                    <span>{{$porcentagemInst}}%</span>
                                </div>



                            </div>
                        </div>
                        <div class="grafico_pizza" id="graficop2">
                            <p>Posts por período</p>
                            <div class="pizza">
                                <canvas id="pizzaCurtidas"></canvas>
                            </div>
                            <div class="infos">
                                <div class="info">
                                    <div>
                                        <div class="bola seg">
                                        </div>
                                        <p>Dia</p>
                                    </div>
                                    <span>{{$porcentagemDia}}%</span>
                                </div>
                                <div class="info">
                                    <div>
                                        <div class="bola naoseg">
                                        </div>
                                        <p>Noite</p>
                                    </div>
                                    <span>{{$porcentagemNoite}}%</span>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="direita">
                    <p>Posts por dia na semana</p>
                    <div>
                        <canvas id="a"></canvas>
                    </div>
                </div>
            </div>
            <div class="tituloPosts-todos">
                <div>
                    <p>Top Posts</p>
                    <a href="/curseiAdm/tdPostInst">Ver Todos</a>
                </div>
            </div>
            <div class="tags-e-cards">
                <div class="hashtags">
                    <div class="tophash">
                        <p>Top Hashtags</p>
                    </div>
                    <div class="lista-de-hashtags">
                        <div class="hashtag">
                            <p class="nomehashtag">#Curso</p>
                            <p>2.4k</p>
                        </div>

                    </div>
                </div>
                <div class="listarCards">

                @foreach($topPosts as $post)   
                    <div class="cardsPost">
                        <div class="topoCard">
                        <img src="{{asset('img/user/fotoPerfil/' . ($post->usuario->img_user ?? 'default-banner.jpg'))}}" alt="Logo" class="logoInstituicao">
                        <h3 class="nomeInstituicao">{{'@'.$post->usuario->arroba_user ?? 'Desconhecido' }}</h3>
                        </div>

                        <p class="descricaoInstituicao">
                                {{ $post->descricao_post }}
                                </p>


                                <div class="imagemPostagem">
                <img src="{{asset('img/user/imgPosts/'.$post->conteudo_post)}}" alt="Imagem do post">
            </div>


                        <div class="infoCard">
                            <div>
                                <span>10.5k</span>
                                Comentarios
                            </div>
                            <div>
                            <span>{{ $post->curtidas_count }}</span>
                                Curtidas
                            </div>
                        </div>


                    </div>
                @endforeach

                  

    
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const barra = document.getElementById("a")
        const stockChart = new Chart(barra, {
            type: 'bar',
            data: {
                labels: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                datasets: [{
                        label: 'Usuarios',
                        data: [<?php foreach ($postsPorDia as $DiaSem) {
                                    echo $DiaSem->total . ",";
                                } ?>],
                        backgroundColor: '#05A4B6   ',
                        borderRadius: 5,
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
                        labels: {
                            usePointStyle: true,

                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false // <- Isso remove as linhas horizontais
                        }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
        const pizza1 = document.getElementById('pizzaContas')
        new Chart(pizza1, {
            type: 'doughnut',
            data: {
                labels: ['Usuarios', 'Instituições'],
                datasets: [{
                    data: [<?=$postUsers?>, <?=$postsInstituicao?>],
                    backgroundColor: ['#1E78FF', '#FFA617'],
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
        const pizza2 = document.getElementById('pizzaCurtidas')
        new Chart(pizza2, {
            type: 'doughnut',
            data: {
                labels: ['Dia', 'Noite'],
                datasets: [{
                    data: ['<?=$postsDia?>','<?=$postsNoite?>'],
                    backgroundColor: ['#05A4B6', '#ff005d'],
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>