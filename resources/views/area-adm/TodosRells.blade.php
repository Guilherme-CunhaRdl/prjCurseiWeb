<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos Os Post da Instituicoes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    @include('area-adm.componentes.links-base')

    <link rel="stylesheet" href="{{asset('css/instituicoesAdm.css')}}">
    <link rel="stylesheet" href="{{asset('css/dashCurtei.css')}}">
</head>
<body>
@include('area-adm.componentes.sidebar')

    <main>

        <div class="container-fluid cont">
        <div class="tituloGeral">
                <p>Todos os Posts</p>
            </div>

            <div class="SelecInputs">
    <div class="pesqInput">
        <input type="text" id="pesquisa" placeholder="Digite o nome do usuario">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <select class="form-select selectInst" id="filtroStatus">
        <option value="all">
            Todos os Posts
        </option>
        <option value="active">
            Posts ativos
        </option>
        <option value="inactive">
            Posts Desativados
        </option>
    </select>

    <select name="Organizar" class="form-select selectInst" id="filtroOrdenacao">
        <option value="mais_vistos">
            Mais Vistos
        </option>
        <option value="mais_curtidos">
            Mais Curtidos
        </option>
        <option value="mais_recentes">
            Mais recentes
        </option>
        <option value="mais_antigos">
            Mais antigos
        </option>
    </select>
</div>

<div class="listarCards">
    @foreach($Curtei as $C)    
    <div class="cardsPost" data-status="{{ $C->status_curtei ? 'active' : 'inactive' }}" data-date="{{ $C->created_at }}">
        <div class="topoCard">
            <img src="{{ asset('img/user/fotoPerfil/' . ($C->usuario->img_user ?? 'default-banner.jpg')) }}" alt="Foto perfil" class="logoInstituicao">
            <div class="userInfo">
                <h3 class="nomeInstituicao">{{ $C->usuario->nome_user ?? 'Desconhecido' }}</h3>
                <small class="tempoPost">{{ $C->created_at->diffForHumans() }}</small>
            </div>
        </div>

        @if($C->legenda_curtei)
        <div class="legendaPost">
            <p>{{ $C->legenda_curtei }}</p>
        </div>
        @endif

        <div class="videoWrapper">
            <div class="videoContainer">
                <video controls class="videoPost" poster="{{ asset($C->caminho_curtei_thumb) }}">
                    <source src="{{ asset($C->caminho_curtei) }}" type="video/mp4">
                </video>
            </div>
        </div>

        <div class="interactionButtons">
            <div class="interactionBtn">
                <i class="fas fa-heart"></i>
                <span>{{ $C->curtidas_count }}</span>
            </div>
            <div class="interactionBtn">
                <i class="fas fa-comment"></i>
                <span>{{ $C->comentarios_count }}</span>
            </div>
            <div class="interactionBtn">
                <i class="fas fa-share"></i>
                <span>{{ $C->compartilhamentos_count }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

    </main>

    <script src="{{asset('js/filtrosCurteiAdm.js')}}"></script>
</body>
</html>