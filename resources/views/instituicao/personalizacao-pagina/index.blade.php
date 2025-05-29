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
    <link rel="stylesheet" href="{{ url('css/personalizacao-instituicao.css') }}">
    <link rel="stylesheet" href="{{ url('css/modal-temas.css') }}">
    <link rel="stylesheet" href="{{ url('css/modal-informacoes.css') }}">
    <link rel="icon" href="{{ asset( 'img/Icone_Logo_Cursei_Preta.png') }}" type="image/x-icon" />

    <script type="text/javascript" src="../js/alterar-tema.js" defer></script>
</head>

<body style="">

    <main class="container-fluid p-0">

        @include('componentes.instituicao.navbar')


        <div class="col-12 flex-row d-flex  " style="margin-top: 98px;">
            
            <div class="col-6 px-5  p-5 ">
                <form action="{{ route('personalizacao.update') }}" method="post" enctype="multipart/form-data">
                    @csrf

                <div class="ps-5 col-10">
                    <div class="col-12">
                        <h1>Personalização de Página</h1>
                    </div>
                    <div class="col-12 d-flex flex-row my-3">
                        <div style="width: 90px">
                            <div class="div-img-alterar">
                                <img class="img-alterar img-fluid carregarImgPerfil" src="{{ url('img/user/fotoPerfil/'. $instituicao->img_user) }}" alt="">
                                <div class="conteudo-img-perfil">
                                    <i class="bi bi-camera"></i>
                                    <label for="imgPerfil" class="h-100 w-100 position-absolute"></label>
                                    <input type="file" name="imgPerfil" accept="image/*" id="imgPerfil" class="d-none">
                                </div>
                            </div>
                        </div>
                        <div class="col-10 d-flex align-items-center">
                            <span class="span-foto-perfil">Foto de Perfil</span>
                        </div>
                    </div>
                    
                    <div class="col-12 ps-2 my-2">
                        <span class="span-frase-banner">Imagem do banner</span>
                    </div>

                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <div class="div-img-banner">
                            <img class="img-banner img-fluid bannerPreview" src="{{url('img/user/bannerPerfil/' . $instituicao->banner_user)}}" alt="">
                            <div class="conteudo-banner">
                                <i class="bi bi-camera"></i>
                                <label class="w-100 h-100 position-absolute " style="opacity: 0;" for="bannerImg">Clique Para Alterar Seu Banner!</label>
                                <input class=" d-none" type="file" accept="image/*" id="bannerImg"  name="imgBanner" >
                            </div>
                        </div>
                    </div>
                    
                    <div class="div-forms col-12">
                        
                            
                            
                        <div class=" col-12 d-flex flex-row my-3" style="height: 50px;">
                            <div class="col-3 d-flex align-items-center">
                                <span class="span-alterar">Nome</span>
                            </div>
                            <div class="col-9 ">
                                <input class="input-alterar" name="nomeInstituicao" type="text" value="{{ $instituicao->nome_user }}" id="input-nome">
                            </div>
                        </div>

                        <div class=" col-12 d-flex flex-row my-3">
                            <div class="col-3 d-flex align-items-center">
                                <span class="span-alterar">Descrição</span>
                            </div>
                            <div class="col-9 ">
                                <textarea  rows="4" class="input-alterar" name="bioInstituicao" id="input-bio"> {{ $instituicao->bio_user }}</textarea>
                            </div>
                        </div>

                        <div class=" col-12 d-flex flex-row my-3" style="height: 50px;">
                            <div class="col-3 d-flex align-items-center">
                                <span class="span-alterar">Usuario</span>
                            </div>
                            <div class="col-9 ">
                                <input class="input-alterar" name="arrobaInstituicao" value="{{ $instituicao->arroba_user }}" type="text" id="input-contato">
                            </div>
                        </div>

                    </div>

                    <div class="col-12 ps-2 mt-4">
                        <button class="botao-salvar" type="submit">Salvar</button>
                        <button class="botao-cancelar" onclick="window.location.href='{{ route('dashboard.index') }}'">Cancelar</button>
                    </div>

                </div>        
            </form>

            </div>

            <div class="col-6 p-5" style="background-color: var(--background-preview);">
                <div class="col-12 p-4">
                    <h3 class="tit-preview ">Preview</h3>
                    <div class="col-12 ">
                        <div class="box-preview-perfil" style="box-sizing: border-box; overflow-y:auto;">
                            <div class="col-12 position-relative">
                                    <img class="banner-preview bannerPreview" src="{{url('img/user/bannerPerfil/' . $instituicao->banner_user)}}" alt="">
                                <div class="div-img-preview-perfil">
                                    <img class="img-preview-perfil carregarImgPerfil" src="{{ url('img/user/fotoPerfil/'. $instituicao->img_user) }}" alt="">
                                </div>
                            </div>
                            <div class="col-12 mt-3  d-flex justify-content-end">
                                <button class="button-editar-preview me-3">Editar Conta</button>
                            </div>

                            <div class="col-12 mt-3 ms-5">
                                <div class="d-flex flex-column">
                                    <span class="nome-usuario-preview" id="nome-user-preview"></span>
                                    <div class="flex-row ">
                                    <span class="arroba-usuario-preview">@</span><span class="arroba-usuario-preview" id="arroba-user-preview"></span>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p id="bio-user-preview">Mane fé filho, é suco de goiaba... da fruta fi, mané fé Mane fé filho, é suco de
                                        goiaba... da fruta fi, mané fé Mane fé filho, é suco de goiaba... da fruta fi,
                                        mané fé</p>
                                </div>
                                <div>
                                    1 <span class="span-seguidores me-3 ">Seguidores</span> 0 <span
                                        class="span-seguidores">Seguindo</span>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="botao-seguindo">Seguindo</button>
                                    <button class="botao-mensagem">Mensagem</button>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 mt-3 ms-5" style=" overflow-y: auto;">
                            @foreach ($posts as $item)
                                
                                <div class="col-12 my-3 mb-5" style="overflow-x: hidden;">
                                <div class="col-12 d-flex flex-row ms-5 pt-2"  >
                                    <div class="box-post-perfil-preview col-1">
                                        <img src="{{ url('img/user/fotoPerfil/'. $item->img_user) }}" alt="">
                                    </div>
                                    <div class="col-11">
                                        <div class="col-12 h-50 d-flex align-items-center ">
                                            <span>{{$item->nome_user}}</span>
                                            .
                                            {{ $item->created_at }}
                                            ...
                                            repub
                                        </div>
                                        <div class="col-12 h-50">
                                            <span>{{ @$item->arroba_user }}</span>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-12 ms-5" >
                                    <p>{{ $item->descricao_post }} </p>
                                    <div class="box-post-conteudo-preview " style="overflow-x: hidden;" >
                                        <img src="{{ url('img/user/imgPosts/' . $item->conteudo_post) }}" alt="">
                                    </div>
                                </div>
                            </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
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

    <script src="{{url('js/atualizar-img.js')}}"></script>
    <script src="{{ url('js/modal-tema.js') }}"></script>
    <script src="{{ url('js/modal-informacoes.js') }}"></script>

</body>

</html>