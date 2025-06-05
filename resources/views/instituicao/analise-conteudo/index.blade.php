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
    <link rel="stylesheet" href="{{ url('css/analise-conteudo.css') }}">
    <link rel="icon" href="{{ asset( 'img/Icone_Logo_Cursei_Preta.png') }}" type="image/x-icon" />

    <script type="text/javascript" src="{{ url('js/alterar-tema.js') }}" defer></script>

</head>

<body>

    <main class="container-fluid p-0">


            <div class="tema-padrao" id="fundo"></div>
                @include('componentes.instituicao.navbar')

        

            <div class="col-12 d-flex justify-content-center">
            <!-- fazer o card de conteudo postado e todo o restante -->
            <div class="div-titulo ">
                    <h1>Seus conteúdos</h1>
                    <p>Informações mais especifícas dos conteúdos postados</p>
            </div>
            </div>

            <div class=" container-fluid  mt-5 d-flex justify-content-around align-items-center">
                <div class="info-engajamento">
                <div class="container-conteudos-postados mb-5" >
                    <div class=" h-100 mb-5 col-12 col-xl-11">
                        <div class="header-info-instituicao flex-row d-flex justify-content-between">
                        <h3>Conteúdo postado</h3>
                        <div class="select-wrapper ">
                            <select name="" id="select-grafico" class="select-biblioteca">
                                <option value="mes">Mês</option>
                                <option value="ultimos6">Ultimos 6 Meses</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="w-100" style="height: 600px;">
                        <canvas id="graficoCurtidas" class="myShart h-100 w-100"></canvas>
                    </div>
                    </div>
                </div>
                
                <div class="container-conteudos-postados mb-5 " style="width: 600px;">
                    <div class="h-50 col-12">
                        <div class="flex-row">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3>Post Mais Curtido</h3>
                            </div>
                        </div>
                        @foreach ($postComMaisCurtidas as $post)
                        <div>
                            <h6 class=""> Todal de Curtidas: <span style="color: var(--cor-tema); ">{{$post->total_curtidas}}</span> </h6>
                        </div>
                        
                        <div class="row h-50 d-flex align-items-center">
                            <div class="box-img-ultimo-curtido">
                                <img src="{{ url('img/user/imgPosts/' . $post->conteudo_post) }}"
                                    class="img-ultimo-curtido" alt="">
                            </div>
                            <div class="col">
                                <h4>{{ $post->titulo_post }}</h4>
                                <p style="color: #868686">{{ $post->descricao_post }}</p>
                                <p> </p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="h-50 mt-5 col-12">
                    <div class="d-flex justify-content-between  align-items-center">
                                <h3>Seguidores</h3>
                            </div>
                        <p>Ultimos 30 dias</p>
                        <div class="d-flex flex-row col-12">
                        @foreach ($ultimoSeguidor as $seguidor)
                       <div class="d-flex row h-50 col-6  justify-content-center  align-items-center ">
                            <div class="  d-flex justify-content-center">
                                <div class="box-img-ultimo-seguidor">
                                <img class="img-ultimo-seguidor" src="{{ url('img/user/fotoPerfil/' . $seguidor->imgUser) }}"
                                 alt="">
                                 </div>
                            </div>
                            <div class="col text-center">
                                <h5>{{ $seguidor->nameUser }}</h5>
                                <p>Ultimo seguidor</p>
                            </div>
                        </div>
                        
                                                @endforeach
                        @foreach ($ultimoCurtidaUser as $item)

                        <div class="d-flex row h-50 col-6  justify-content-center  align-items-center ">
                           <div class=" d-flex justify-content-center">
                                <div class="box-img-ultimo-seguidor">
                                <img class="img-ultimo-seguidor" src="{{ url('img/user/fotoPerfil/' . $item->imgUser) }}"
                                 alt="">
                                 </div>
                            </div>
                            <div class="col text-center">
                                <h5>{{ $item->nameUser }}</h5>
                                <p>Ultima Curtida</p>
                            </div>
                        </div>
                        @endforeach
                        </div>

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