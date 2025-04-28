<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    @include('area-adm.componentes.links-base')
    <link rel="stylesheet" href="{{ asset('css/DashboardAdm.css') }}">
</head>

<body>
    @include('area-adm.componentes.sidebar')
    <main>
    <?php
    
    
    
    ?>
        <div class="container-fluid cont">
            <div class="tituloPag">
                <p>Dashboard</p>
            </div>
            <div class="lista-cards">
                <a href="/curseiAdm/usuarios" class="card-dashboard">
                    <div class="topo">
                        <p>Usuarios Ativos</p>
                        <div class="icone"> <i class='bx bx-user'></i></div>
                    </div>
                    <p class="numero">{{$usuarios}}</p>
                    <p class="info">AUMENTO DE {{$aumentoUser}}% <i class='bx bx-trending-up'></i></p>
                </a>
                <a href="/curseiAdm/instituicao" class="card-dashboard">
                    <div class="topo">
                        <p>Instituições Ativas</p>
                        <div class="icone"> <i class='bx bxs-institution'></i></div>
                    </div>
                    <p class="numero">{{$instituicoes}}</p>
                    <p class="info">AUMENTO DE {{$aumentoInst}}% <i class='bx bx-trending-up'></i></p>
                </a>
                <a href="/curseiAdm/posts" class="card-dashboard">
                    <div class="topo">
                        <p>Posts Publicados</p>
                        <div class="icone"> <i class='bx bx-photo-album'></i></div>
                    </div>
                    <p class="numero">{{$posts}}</p>
                    <p class="info">AUMENTO DE {{$aumentoPosts}}% <i class='bx bx-trending-up'></i></p>
                </a>

            </div>
            <div class="graficos">
                <div class="grafico_barra">
                    <p>Novas contas por mês</p>
                    <canvas id="grafico_barra"></canvas>
                </div>
                <div class="grafico_pizza">
                    <p>Acessos por periodo</p>
                    <div class="pizza">
                        <canvas id="pizza"></canvas>
                    </div>
                    <div class="infos">
                        <div class="info">
                            <div>
                                <div class="bola manha">
                                </div>
                                <p>Manhã (06:00-12:00)</p>
                            </div>
                            <span>30%</span>
                        </div>
                        <div class="info">
                            <div>
                                <div class="bola tarde">
                                </div>
                                <p>Tarde (12:00-18:00)</p>
                            </div>
                            <span>20%</span>
                        </div>
                        <div class="info">
                            <div>
                                <div class="bola noite">
                                </div>
                                <p>Noite (18:00-06:00)</p>
                            </div>
                            <span>50%</span>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </main>








    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const barra = document.getElementById("grafico_barra")
        const stockChart = new Chart(barra, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                        label: 'Usuarios',
                        data: [<?php foreach($usuariosPorMes as $userMes){
                           echo $userMes-> total.",";
                        } ?>],
                        backgroundColor: '#00565f',
                        borderRadius: 5,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Instituições',
                        data: [<?php foreach($instituicoesPorMes as $instMes){
                           echo $instMes-> total.",";
                        } ?>],
                        backgroundColor: '#05A4B6',
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
        // grafico redondo
        const pizza = document.getElementById('pizza')
        new Chart(pizza, {
            type: 'doughnut',
            data: {
                labels: ['Noite (18:00–06:00)', 'Manhã (06:00–12:00)', 'Tarde (12:00–18:00)'],
                datasets: [{
                    data: [38, 20, 42],
                    backgroundColor: ['#6cedfc', '#27B8C8', '#034a52'],
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
    <script src="sidebarAdm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>