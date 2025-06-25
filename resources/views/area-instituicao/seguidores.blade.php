<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seguidores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/dashboardInst.css') }}">
    <link rel="stylesheet" href="{{ asset('css/seguidoresInst.css') }}">
    @include('area-instituicao.componentes.padrao')
</head>

<body>
    @include('area-instituicao.componentes.sidebar')

    <main>
        @include('area-instituicao.componentes.navbar', [
            'navbarIcon' => 'bx-user',
            'titulo' => 'Seguidores',
        ])

        <div class="container-fluid cont">
            <div class="esquerda" style="width:100%;">

                <div class="filtros-seguidores" style="margin-bottom: 0;">
                    <input type="text" id="procurar" class="input-busca" placeholder="Busque pelo nome do seguidor">
                    <select id="filtroTempo" class="input-ordenar">
                        <option disabled>Ordenar por</option>
                        <option value="nome_asc" selected>Ordem Alfabetica</option>
                        <option value="recente_desc">Mais Recente</option>
                        <option value="recente_asc">Menos Recente</option>
                    </select>
                </div>
                <div class="tabela-seguidores" style="margin-top: 10px;">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($seguidores as $seguidor)
                                <tr class="follower-row" data-nome="{{ strtolower(string: $seguidor['nome_user']) }}"
                                    data-arroba="{{ strtolower($seguidor['arroba_user']) }}"
                                    data-email="{{ strtolower($seguidor['email_user']) }}"
                                    data-data="{{ $seguidor['created_at'] }}">
                                    <td>
                                        <div class="info-user">
                                            <img src="{{ $seguidor['img_user'] ? asset('img/user/fotoPerfil/' . $seguidor['img_user']) : asset('img/user/fotoPerfil/padrao.png') }}"
                                                alt="Foto" class="foto-user">
                                            <div>
                                                <div class="nome-user">{{ $seguidor['nome_user'] ?? 'Nome do usuário' }}
                                                </div>
                                                <div class="arroba-user">@ {{ $seguidor['arroba_user'] ?? 'usuario' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $seguidor['email_user'] ?? 'email@email.com' }}</td>
                                    <td>
                                        <!-- Botão de ver perfil -->
                                        <button class="btn-acao" title="Ver Perfil"
                                            onclick="abrirModalPerfil({
                    banner: '{{ $seguidor['banner_user'] ? asset('img/user/bannerPerfil/' . $seguidor['banner_user']) : asset('img/user/bannerPerfil/padrao.png') }}',
                    foto: '{{ $seguidor['img_user'] ? asset('img/user/fotoPerfil/' . $seguidor['img_user']) : asset('img/user/fotoPerfil/padrao.png') }}',
                    nome: '{{ $seguidor['nome_user'] }}',
                    arroba: '{{ $seguidor['arroba_user'] }}',
                    bio: '{{ $seguidor['bio_user'] ?? '' }}',
                    seguidores: '{{ $seguidor['total_seguidores'] ?? 0 }}',
                    seguindo: '{{ $seguidor['total_seguindo'] ?? 0 }}'
                })">
                                            <i class='bx bx-info-circle'></i>
                                        </button>

                                        <button class="btn-acao" title="Remover Seguidor"
                                            onclick="abrirModalRemover('{{ $seguidor['arroba_user'] }}', '{{ $seguidor['id'] }}', '{{ $user->id }}')">
                                            <i class='bx bx-user-minus'></i>
                                        </button>
                                    </td>
                                </tr>


                            @empty
                                <tr>
                                    <td colspan="3" class="nenhum">Nenhum seguidor encontrado.</td>
                                </tr>
                            @endforelse

                            <div id="modal-remover" class="modal-seguidores" style="display:none;">
                                <div class="modal-conteudo">
                                    <p class="modal-titulo">
                                        Deseja retirar <span class="modal-arroba">@<span
                                                id="modal-arroba"></span></span> de seus seguidores?
                                    </p>
                                    <div class="modal-botoes">
                                        <button class="btn-cancelar"
                                            onclick="fecharModal('modal-remover')">Cancelar</button>
                                        <a id="confirmar-remocao-link" href="#">
                                            <button class="btn-confirmar" id="btn-confirmar-remover">Confirmar</button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal: Confirmar remoção de seguidor -->

    <!-- Modal: Ver perfil do seguidor -->
    <div id="modal-perfil" class="modal-seguidores" style="display:none;">
        <div class="modal-conteudo perfil perfil-cursei-modal">
            <div class="perfil-banner-box">
                <img id="modal-banner" src="" alt="Banner" class="perfil-banner-img">
                <div class="perfil-foto-box">
                    <img id="modal-foto" src="" alt="Foto" class="perfil-foto-img">
                </div>
            </div>
            <div class="perfil-info-box">
                <div class="perfil-nome-arroba-box">
                    <span class="perfil-nome" id="modal-nome">EL CHAVO DEL OCHO</span>
                    <span class="perfil-arroba" id="modal-arroba-perfil">@elchavo_del_ocho</span>
                    <span class="perfil-bio-box" id="modal-bio">
                        Se você é jovem ainda, amanhã velho será! Se você é jovem ainda, amanhã velho será! Se você é
                        jovem ainda, amanhã velho será!
                    </span>
                    <div class="perfil-contagem-box">
                        <span><b id="modal-seguidores">1</b> <span class="contagem-label">Seguidores</span></span>
                        <span><b id="modal-seguindo">0</b> <span class="contagem-label">Seguindo</span></span>
                    </div>
                </div>
            </div>
            <button class="btn-fechar" onclick="fecharModal('modal-perfil')">Fechar</button>
        </div>
    </div>

    <script>
        function abrirModalRemover(arroba, seguidorId, instituicaoId) {
            document.getElementById('modal-arroba').innerText = arroba;
            const link = document.getElementById('confirmar-remocao-link');
            link.href = `/curseiInstituicao/retirarUsuarioSeguidor/${seguidorId}/${instituicaoId}`;
            document.getElementById('modal-remover').style.display = 'flex';
        }

        function abrirModalPerfil(dados) {
            document.getElementById('modal-banner').src = dados.banner || '{{ asset('img/default-banner.png') }}';
            document.getElementById('modal-foto').src = dados.foto || '{{ asset('img/default-user.png') }}';
            document.getElementById('modal-nome').innerText = dados.nome || 'Nome do usuário';
            document.getElementById('modal-arroba-perfil').innerText = '@' + (dados.arroba || 'usuario');
            document.getElementById('modal-bio').innerText = dados.bio || '';
            document.getElementById('modal-seguidores').innerText = dados.seguidores || 0;
            document.getElementById('modal-seguindo').innerText = dados.seguindo || 0;
            document.getElementById('modal-perfil').style.display = 'flex';
        }

        function fecharModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
    @include('area-instituicao.componentes.modal-notificacao')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const procurar = document.getElementById('procurar');
            const filtroTempo = document.getElementById('filtroTempo');
            const followerRows = document.querySelectorAll('.follower-row');

            function pesquisarSeguidores() {
                const searchTerm = procurar.value.toLowerCase();

                followerRows.forEach(row => {
                    const nome = row.getAttribute('data-nome');
                    const arroba = row.getAttribute('data-arroba');
                    const email = row.getAttribute('data-email');

                    if (nome.includes(searchTerm) ||
                        arroba.includes(searchTerm) ||
                        email.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            function filtrarSeguidores() {
                const sortValue = filtroTempo.value;
                const tbody = document.querySelector('.tabela-seguidores tbody');
                const rows = Array.from(tbody.querySelectorAll('.follower-row:not([style*="display: none"])'));

                rows.sort((a, b) => {
                    switch (sortValue) {
                        case 'nome_asc':
                            return a.getAttribute('data-nome').localeCompare(b.getAttribute('data-nome'));
                        case 'recente_desc':
                            return new Date(b.getAttribute('data-data')) - new Date(a.getAttribute(
                                'data-data'));
                        case 'recente_asc':
                            return new Date(a.getAttribute('data-data')) - new Date(b.getAttribute(
                                'data-data'));
                        default:
                            return 0;
                    }
                });

                rows.forEach(row => tbody.appendChild(row));
            }

            procurar.addEventListener('input', pesquisarSeguidores);
            filtroTempo.addEventListener('change', filtrarSeguidores);
            filtrarSeguidores();

        });
    </script>
</body>

</html>
