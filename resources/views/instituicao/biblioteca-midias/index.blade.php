<!DOCTYPE html>
<html lang="en">
    <script>
        const temaSalvo = localStorage.getItem('tema');
        if (temaSalvo) {
            document.documentElement.className = temaSalvo;
        }
    </script>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cursei</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ url('css/biblioteca-midias.css') }}" />
    <link rel="stylesheet" href="{{ url('css/modal-temas.css') }}">
    <link rel="stylesheet" href="{{ url('css/modal-informacoes.css') }}">
    <link rel="stylesheet" href="{{ url('css/modalCriacaoPost.css') }}">
    <link rel="icon" href="{{ asset( 'img/Icone_Logo_Cursei_Preta.png') }}" type="image/x-icon" />

    <script type="text/javascript" src="../js/alterar-tema.js" defer></script>
</head>

<body >
    <main class="container-fluid p-0 ">
        <!-- a  div laranja é o fundo da nossa pagina -->

        <div class="tema-padrao " id="fundo"></div>

        @include('componentes.instituicao.navbar')


        <div class="col-12 d-flex justify-content-center">
            <div class="div-titulo">
                <h1>Todos conteúdos postados!</h1>
                <p>Os conteúdos que te levaram até aqui!</p>
            </div>
        </div>

        <div class="container-fluid mt-5 d-flex  justify-content-center align-items-center">
            <div class="container-conteudos-postados mb-5 col-12 col-xl-11   ">
                <div class="header-info d-lg-flex d-none">
                    <h3>Conteudo da Página</h3>
                    <div class="categorias col-12 col-xl-10 ">
                        
                        <button class="botaoCriarPost" onclick="abrirModalCriarPost()">Criar uma publicação +</button>

                        <form action="{{ route('biblioteca.filtrar') }}" method="get">

                        <div class="select-wrapper">
                            <select name="curtidas" id="" class="select-biblioteca" onchange="this.form.submit()">
                                <option value="" selected disabled>Curtidas</option>
                                <option value="maior" {{ request('curtidas') == 'maior' ? 'selected' : '' }}>Mais Curtidos</option>
                                <option value="menor" {{ request('curtidas') == 'menor' ? 'selected' : '' }}>Menos Curtidos</option>
                            </select>
                        </div>
                        <div class="select-wrapper">
                            <select name="mes" id="" class="select-biblioteca" onchange="this.form.submit()">
                                <option value="" selected disabled>Mês</option>
                                <option value="1" {{ request('mes') == 1 ? 'selected' : '' }}>Janeiro</option>
                                <option value="2" {{ request('mes') == 2 ? 'selected' : '' }}>Fevereiro</option>
                                <option value="3" {{ request('mes') == 3 ? 'selected' : '' }}>Março</option>
                                <option value="4" {{ request('mes') == 4 ? 'selected' : '' }}>Abril</option>
                                <option value="5" {{ request('mes') == 5 ? 'selected' : '' }}>Maio</option>
                                <option value="6" {{ request('mes') == 6 ? 'selected' : '' }}>Junho</option>
                                <option value="7" {{ request('mes') == 7 ? 'selected' : '' }}>Julho</option>
                                <option value="8" {{ request('mes') == 8 ? 'selected' : '' }}>Agosto</option>
                                <option value="9" {{ request('mes') == 9 ? 'selected' : '' }}>Setembro</option>
                                <option value="10" {{ request('mes') == 10 ? 'selected' : '' }}>Outubro</option>
                                <option value="11" {{ request('mes') == 11 ? 'selected' : '' }}>Novembro</option>
                                <option value="12" {{ request('mes') == 12 ? 'selected' : '' }}>Dezembro</option>
                            </select>
                        </div>
                        <div class="select-wrapper">
                            <select name="restricao" id="" class="select-biblioteca" onchange="this.form.submit()">
                                <option selected disabled>Restrições</option>
                                <option value="1" {{ request('restricao') == 1 ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ request('restricao') == 0 && request('restricao') != null ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </form>

                    </div>
                </div>
                <div class="container-info-instituicao d-lg-flex d-none">
                    <div class="conteudo-infos row ms-1 ">
                        <div class="col-4">
                            <span>Video</span>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <span>Visibilidade</span>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <span>Data</span>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <span>Comentarios</span>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <span>Curtidas</span>
                        </div>
                    </div>

                    @foreach ($posts as $item)
                        
                    <div class="div-informacoes-instituicao row ms-1">
                        <div class="col-4 d-flex flex-row">
                            <div class="col-7">
                                <div class="box-img-post">
                                    <img src="{{ url('img/user/imgPosts/'. $item->conteudo_post)  }}" class="img-fluid" alt="" />
                                </div>
                            </div>

                            <div class="col-5 ms-3 mt-1" style="word-break: break-all">
                                <h5>{{ $item->titulo_post }}</h5>
                                <p class="info-post-txt">
                                   {{$item->descricao_post}}
                                </p>
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-center">
                            <span class="info-post-txt" >{{ $item->status_post === 0 ? 'Inativo' : 'Ativo' }}</span>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-center">
                            <span class="info-post-txt" >{{$item->created_at}}</span>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-center">
                            <span class="info-post-txt" >{{ $item->total_comentarios }}</span>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-center">
                            <span class="info-post-txt" >{{ $item->total_curtidas }}</span>
                        </div>
                    </div>
                    @endforeach

            
                    

                            
                    



                </div> 

                <div class="col-12 bg-info d-lg-none d-flex flex-column">
                    <div class="header-info flex-column">
                        <div class="col-12 text-center">
                            <h3>Conteudo Postado</h3>
                        </div>

                        <div class="select-wrapper">
                            <select name="" id="" class="select-biblioteca">
                                <option value="">Visualizações</option>
                                <option value="">Menos Visualizações</option>
                                <option value="">Mais Visualizações</option>
                            </select>
                        </div>
                        <div class="select-wrapper">
                            <select name="" id="" class="select-biblioteca">
                                <option value="">Visualizações</option>
                                <option value="">Menos Visualizações</option>
                                <option value="">Mais Visualizações</option>
                            </select>
                        </div>
                        <div class="select-wrapper">
                            <select name="" id="" class="select-biblioteca">
                                <option value="">Visualizações</option>
                                <option value="">Menos Visualizações</option>
                                <option value="">Mais Visualizações</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="box-img-post">
                            <img src="" alt="">
                        </div>
                    </div>
                    <div class="col-12">
                        <ul>
                            <li>Titulo</li>
                            <li>Descrição</li>
                        </ul>
                        <ul class="d-flex flex-row gap-5">
                            <li>Data</li>
                            <li>Visualizações</li>
                            <li>Ativo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Div branca ta apenas flutuando com um fixed -->

        <div class="div-branca"></div>
    </main>

    @include('componentes.instituicao.modal-temas')
    @include('componentes.instituicao.modal-informacoes')
    @include('componentes.instituicao.modal-criacao-post')


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

    <!-- Biblioteca de Graficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ url('js/modal-tema.js') }}"></script>
    <script src="{{ url('js/modal-informacoes.js') }}"></script>
    <script src="{{ url('js/modal-post.js') }}"></script>
    <script src="{{ url('js/atualizar-img-post.js') }}"></script>
</body>

</html> 