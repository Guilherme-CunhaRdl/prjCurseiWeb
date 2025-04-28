<!DOCTYPE html>
<html lang="en">
<script>
    const temaSalvo = localStorage.getItem('tema');
    if (temaSalvo) {
        document.documentElement.className = temaSalvo;
    }
</script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analise de conteúdo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="{{ url('css/modal-temas.css') }}">
    <link rel="stylesheet" href="{{ url('css/modal-informacoes.css') }}">

    <script type="text/javascript" src="../js/alterar-tema.js" defer></script>

</head>

<body>

    <main class="container-fluid p-0  containerAnalise ">

        @include('componentes.instituicao.navbar')


        <div class="container" style="padding-top: 105px;">


            <!-- fazer o card de conteudo postado e todo o restante -->
            <div class="d-flex align-items-center div-titulo">
                <div>
                    <h1>Seus conteúdos</h1>
                    <p>Informações mais especifícas dos conteúdos postados</p>
                </div>
            </div>
            <div class="d-flex justify-content-between divs-conteudo left-0">
                <div class="bg-white text-black p-3 divConteudoPostado">
                    <div class="d-flex flex-row justify-content-between m-3 align-items-center">
                        <h3>Conteúdo postado</h3>
                        <div class="select-wrapper ">
                            <select name="" id="select-grafico" class="select-grafico">
                                <option value="mes">Mês</option>
                                <option value="ultimos6">Ultimos 6 Meses</option>
                            </select>
                        </div>
                    </div>
                    <div class="div-grafico">
                        <canvas id="graficoCurtidas" class="myShart"></canvas>
                    </div>
                </div>

                <div class=" text-black bg-white p-4 divEspectadores">
                    <div class="h-50  overflow-hidden">
                        <div class=" flex-row">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3>Espectadores recorrentes</h3>
                                <i class="bi bi-arrow-right-circle" style="font-size: 30px;"></i>
                            </div>
                            <p>Ultimos 30 dias</p>
                        </div>
                        <div>
                            <h6 class=""> 20.000.000 vindo de: </h6>
                        </div>
                        @foreach ($postsMaisCurtidos as $post)
                        <div class="p-2 row h-50 d-flex align-items-center conteudoEspectadoresRecorrentes">
                            <div class="divImgEspectadores">
                                <img src="{{ url('img/user/imgPosts/' . $post->conteudo_post) }}"
                                    class="imgEspectadoresRecorrentes" alt="">
                            </div>
                            <div class="col">
                                <h5>{{ $post->titulo_post }}</h5>
                                <p> Engajamento: {{$post->total_curtidas}}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="h-50 mt-2 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                                <h3>Seguidores novos</h3>
                                <i class="bi bi-arrow-right-circle" style="font-size: 30px;"></i>
                            </div>
                        <p>Ultimos 30 dias</p>
                        @foreach ($ultimoSeguidor as $seguidor)
                        <div class="p-2 row h-50 d-flex align-items-center conteudoEspectadoresRecorrentes">
                            <div class="divImgEspectadores ">
                                <img src="{{ url('img/user/fotoPerfil/' . $seguidor->imgUser) }}"
                                    class="imgEspectadoresRecorrentes" alt="">
                            </div>
                            <div class="col">
                                <h5>{{ $seguidor->nameUser }}</h5>
                                <p>Ultimo seguidor</p>
                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>

    </main>
    @include('componentes.instituicao.modal-temas')
    @include('componentes.instituicao.modal-informacoes')

    <script src="{{ url('js/modal-tema.js') }}"></script>
    <script src="{{ url('js/modal-informacoes.js') }}"></script>

</body>
<script>
    // Passar os dados dos posts mais curtidos para o JavaScript
    window.postsMaisCurtidos = @json($postsMaisCurtidos);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/grafico-analise-conteudo.js"></script>

</html>