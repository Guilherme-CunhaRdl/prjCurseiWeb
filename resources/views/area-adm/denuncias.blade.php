<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    @include('area-adm.componentes.links-base')

    <link rel="stylesheet" href="{{asset('css/denunciasAdm.css')}}">
</head>

<body>
    @include('area-adm.componentes.sidebar')


    <main>
        <div class="container-fluid cont">
            <div class="tituloPag">
                <p >Denúncias</p>
            </div>
            <div class="inputs">
                <div class="contInput">
                    <input type="text" id="pesquisa" placeholder="Pesquise pelo nome do usuario">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>


                <select name="Organizar" class="form-select">
    <option value="Mais recentes">
        Mais recentes
    </option>
    <option value="Mais antigos">
        Mais antigos
    </option>
</select>

            </div>
            <div class="lista-cards" id="cardsPadrao">
            @foreach ($denuncias as $denuncia)
    <div class="card">
        <div class="info">
            <p id="usuario">{{ $denuncia->autor->nome_user }}</p>
            <p>{{ $denuncia->motivo_denuncia }}</p>
            <p>{{ $denuncia->denunciado->nome_user }}</p>
            <p class="data-denuncia" style="display: none;">{{ $denuncia->created_at ? $denuncia->created_at->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
        </div>
        <div class="acoes">
            <a href="#"><i class='bx bx-info-circle' onclick="abrirModalDenuncia('{{$denuncia->autor->nome_user}}','{{$denuncia->motivo_denuncia}}','{{$denuncia->denunciado->nome_user}}','{{$denuncia->created_at ? $denuncia->created_at->format('d/m/Y H:i:s') : 'Data não disponível'}}','{{$denuncia->descricao_denuncia ?? "Nenhuma descrição fornecida"}}')"></i></a>
        </div>
    </div>
@endforeach
                </div>

                <div class="lista-cards" id="cardsPesquisa"></div>
            </div>

    </main>
    <div class="container-modal-denuncia" onclick="fecharforaDenuncia(event)">
        <div class="modal-denuncia">
            <div class="topo-modal-denuncia">
                <p>Detalhes da Denúncia</p>
                <i class='bx bx-x' onclick="fecharModalDenuncia()"></i>
            </div>
            <div class="infos-modal-denuncia">
                <div class="info-modal">
                    <p>Quem Denunciou:</p>
                    <p class="info-modal-container verde" id="autor">Eduardo santana santos</p>
                </div>
                <div class="info-modal">
                    <p>Tipo da Denúncia:</p>
                    <p class="info-modal-container vermelho" id="tipo">Eduardo santana santos</p>
                </div>
                <div class="info-modal">
                    <p>Usuário Denunciado:</p>
                    <p class="info-modal-container vermelho" id="denunciado">Eduardo santana santos</p>
                </div>
                <div class="info-modal">
                    <p>Data:</p>
                    <p class="info-modal-container cinza" id="data" style="color: white;">15/04/2025 13:40</p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    



    <script src="{{asset('js/denunciasAdm.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>