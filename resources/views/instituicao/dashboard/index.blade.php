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
        <title>Cursei</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="{{ url('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ url('css/modal-temas.css') }}">
        <link rel="stylesheet" href="{{ url('css/modal-informacoes.css') }}">

        <script type="text/javascript" src="../js/alterar-tema.js" defer></script>
    </head>


    <body>

        <main class="container-fluid  p-0 ">
            <!-- a  div laranja é o fundo da nossa pagina -->
            <div class="tema-padrao " id="fundo"></div>
            
            @include('componentes.instituicao.navbar')

                <div class="col-12 d-flex justify-content-center">
                    <div class="div-titulo">
                        <h1>Olá, {{ $instituicao->nome_user }}!</h1>
                        <p>É hora de fazer o que fazemos de melhor!</p>
                    </div>
                </div>

                <div class="container-fluid  mt-5  d-flex justify-content-center align-items-center ">
                    <div class="info-dashboard  ">
                        <div class="box-grafico-engajamento d-none  d-md-grid align-items-start ">
                            <div class="conteudo-grafico-engajamento">
                                <div class="d-flex flex-row justify-content-between col-12">
                                    <h3>Engajamento da Página</h3>
                                    <div class="select-wrapper">
                                        <select name="" id="select-grafico" class="select-grafico">
                                            <option value="mes">Mês</option>
                                            <option value="ultimos6">Ultimos 6 Meses</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="div-grafico">
                                    <canvas class="myChart"></canvas>
                                </div>

                            </div>
                        </div>
                        
                        
                        <div class="box-ultimo-editado d-none  d-md-grid">
                            <div class="p-1 d-flex justify-content-between align-items-center flex-column h-100 ">
                                <div class="col-12 d-flex justify-content-between align-items-center ">
                                    <h3>Ultimo Editado</h3>
                                    <i class="bi bi-arrow-right-circle" style="font-size: 30px;"></i>
                                </div>
                                @foreach ($ultimoPost as $item)

                                <div class="d-flex flex-row w-100 h-100 d-none align-items-center d-xxl-flex">
                                    <div class="box-img-ultimo-editado">
                                        <img class=" img-fluid" src="{{ url('img/user/imgPosts/' . $item->conteudo_post) }}" alt="">
                                    </div>
                                    <div class="d-flex justify-content-center flex-column ms-3">
                                        <h3>{{ $item->titulo_post }}</h3>
                                        <p style="color: #868686;"> {{ $item->descricao_post }} </p>
                                    </div>
                                </div>

                                <div class="d-flex flex-column  align-items-center text-center w-100 h-100 d-flex d-xxl-none">
                                    <div class="box-img-ultimo-editado mt-4">
                                        <img class="img-fluid" src="{{ url('img/user/imgPosts/' . $item->conteudo_post) }}" alt="">
                                    </div>
                                    <div class="d-flex justify-content-center py-2 flex-column ms-3">
                                        <h3>{{ $item->titulo_post }}</h3>
                                        <p style="color: #868686;">{{ $item->descricao_post }} </p>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>

                            
                        <div class="box-planejados d-none  d-md-grid">
                            <div class="p-1 d-flex col-12 align-items-start flex-column h-100">
                                <div class="col-12 ">
                                    <h3>Planejados</h3>
                                </div>
                                <div class="col-12 d-none flex-column d-xxl-flex">
                                    @foreach ($planejados as $item)

                                    <div class="col-12 my-2 d-none d-xxl-flex" style="height: 120px;">

                                        <div class="col-12 d-flex flex-row h-100  ">
                                            <div class="box-img-planejados col-3">
                                                <img class="img-fluid" src="{{url('img/user/imgPosts/' . $item->conteudo_post)}}" alt="">
                                            </div>
                                            <div class="col-8 ms-3 d-flex flex-column text-start justify-content-center">
                                                <div class="d-flex align-items-end  justify-content-between col-12 h-50">
                                                    <h3>{{ $item->nome_planejamento }}</h2>
                                                        <i class="bi bi-arrow-left-circle" style="font-size: 30px;"></i>

                                                </div>
                                                <div class="col-12 h-50 d-flex align-items-start ">
                                                    <p style="color: #868686;">{{$item->descricao_post}}</p>

                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                        @endforeach

                                   


                                    </div>
                                </div>



                                <!-- Essa div é uma div especifica do tamanho 981px  -->

                                <div class="col-12 d-xxl-none  flex-column d-flex" h-100>
                                    <div class="col-12  d-flex flex-column justify-cont align-items-center">
                                        <div class="box-img-planejados col-12">
                                            <img class="img-fluid" src="" alt="">
                                        </div>

                                        <div class="d-flex flex-row justify-content-between w-100 px-3">
                                            <h3>Estude na Etec!</h2>
                                                <i class="bi bi-arrow-left-circle" style="font-size: 30px;"></i>

                                        </div>
                                        <div class="col-12 h-50 d-flex align-items-start justify-content-center ">
                                            <p style="color: #868686;">A melhor oportunidade</p>

                                        </div>
                                    </div>

                                </div>




                            </div>
                        </div>


                    </div>



                </div>




                <div class="container-fluid justify-content-center d-flex d-md-none">
                    <div class="info-dashboard">
                        <div class="box-grafico-engajamento d-md-none  d-grid align-items-start">
                            <div class="conteudo-grafico-engajamento">
                                <div class="d-flex flex-row justify-content-between col-12">
                                    <h3>Engajamento da Página</h3>
                                    <div class="select-wrapper">
                                        <select name="" id="" class="select-grafico">
                                            <option value="">Mês</option>
                                            <option value="">Semestre</option>
                                            <option value="">Ano</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="div-grafico">
                                    <canvas class="myChart"></canvas>
                                </div>

                            </div>
                        </div>

                        <div class="box-ultimo-editado d-md-none  d-grid">
                            <div class="p-1 d-flex justify-content-between align-items-center flex-column h-100 ">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <h3>Ultimo Editado</h3>
                                    <i class="bi bi-arrow-right-circle" style="font-size: 30px;"></i>
                                </div>
                                <div class="d-flex flex-row w-100 h-100 d-flex d-xl-none">
                                    <div class="box-img-ultimo-editado">
                                        <img class="img-fluid" src="" alt="">
                                    </div>
                                    <div class="d-flex justify-content-center flex-column ms-3">
                                        <h3>Estude na Etec!</h3>
                                        <p style="color: #868686;">A melhor etec para ter ideias é essa, venha para a etec
                                            de XXXXX!</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="box-planejados d-md-none  d-grid">
                            <div class="p-1 d-flex col-12 align-items-start flex-column h-100">
                                <div class="col-12 ">
                                    <h3>Planejados</h3>
                                </div>
                                <div class="col-12 d-flex flex-column d-xxl-none">
                                    <div class="col-12 my-2 d-flex d-xxl-none" style="height: 120px;">
                                        <div class="col-12 d-flex flex-row h-100  ">
                                            <div class="box-img-planejados col-3">
                                                <img class="img-fluid" src="" alt="">
                                            </div>
                                            <div class="col-8 ms-3 d-flex flex-column text-start justify-content-center">
                                                <div class="d-flex align-items-end  justify-content-between col-12 h-50">
                                                    <h3>Estude na Etec!</h2>
                                                        <i class="bi bi-arrow-left-circle" style="font-size: 30px;"></i>

                                                </div>
                                                <div class="col-12 h-50 d-flex align-items-start ">
                                                    <p style="color: #868686;">A melhor oportunidade</p>

                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                    <div class="col-12 my-2 " style="height: 120px;">
                                        <div class="col-12 d-flex flex-row h-100  ">
                                            <div class="box-img-planejados col-3">
                                                <img class="img-fluid" src="" alt="">
                                            </div>
                                            <div class="col-8 ms-3 d-flex flex-column text-start justify-content-center">
                                                <div class="d-flex align-items-end  justify-content-between col-12 h-50">
                                                    <h3>Estude na Etec!</h2>
                                                        <i class="bi bi-arrow-left-circle" style="font-size: 30px;"></i>

                                                </div>
                                                <div class="col-12 h-50 d-flex align-items-start ">
                                                    <p style="color: #868686;">A melhor oportunidade</p>

                                                </div>
                                            </div>

                                        </div>


                                    </div>


                                </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Div branca ta apenas flutuando com um fixed -->

                    <div class="div-branca "></div>

        </main>

        @include('componentes.instituicao.modal-temas')
        @include('componentes.instituicao.modal-informacoes')

        <script>
             window.seguidores = @json($listaSeguidores); 
             window.curtidas = @json($listaCurtidas); 
             window.seguidores6Meses = @json( $seguidores6Meses);
             window.nomeMeses6Meses = @json($nomeUltimos6Meses);
        </script>
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>

        <!-- Biblioteca de Graficos -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script src="../js/grafico-engajamento.js"></script>
        <script src="{{ url('js/modal-tema.js') }}"></script>
        <script src="{{ url('js/modal-informacoes.js') }}"></script>

    </body>

    </html>