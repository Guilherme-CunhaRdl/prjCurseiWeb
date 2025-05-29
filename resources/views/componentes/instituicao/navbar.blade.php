<nav class="nav-bar">
    <div class="d-flex  justify-content-center align-items-center col-2">
        <span class="logo-nav">CURSEI</span>
    </div>
    <div class="links-nav d-md-flex d-none  justify-content-evenly align-items-center col-8">
        <a href="{{ route('dashboard.index') }}"><span>Dashboard</span></a>
        <a href="{{ route('analiseConteudo')}}"><span>Analise de Conteudo</span></a>
        <a href="{{ route('biblioteca.index') }}"><span>Biblioteca de Midias</span></a>
    </div>

    <div class="d-flex justify-content-center align-items-center col-2" >
        <button class="nav-link dropdown-toggle botao-dropdown d-flex flex-row justify-content-center align-items-center" style="color: var(--cor-fonte)" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="div-img-instituicao-perfil">
                <img class="img-instituicao img-fluid" src="{{ url('img/user/fotoPerfil/' . $instituicao->img_user) }}" alt="">
            </div>
        </button>
        <ul class="dropdown-menu"  >
            <li><a class="dropdown-item" href="{{ route('personalizacao.index') }}">Alterar Perfil</a></li>
            <li><button class="dropdown-item"  onclick="abrirModalInformacoes()">Informações Instituição</button></li>
            <li><button class="dropdown-item"  onclick="abrirModalTema()">Alterar Tema</button></li>
            <li><a class="dropdown-item" href="{{route('logout')}}">Logoff</a></li>
        </ul>
    </div>
    
</nav>