
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardInst.css') }}">
    <link rel="stylesheet" href="{{ asset('css/padraoInst.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contaInst.css') }}">

    @include('area-instituicao.componentes.padrao')
</head>
<body>
    @include('area-instituicao.componentes.sidebar')

    <main>
        @include('area-instituicao.componentes.navbar', [
            'navbarIcon' => 'bx-user',
            'titulo' => 'Conta'
        ])

        <div class="container-fluid cont">
            <div class="esquerda" style="width:100%;">

                <!-- Perfil no Cursei -->
                <div class="card-conta perfil-cursei">
    <div class="header">
        <img src="{{ asset('img/Icone_Logo_Cursei_Preta.png') }}" style="width:38px; height:32px;">
        <span class="titulo">Perfil no Cursei</span>
    </div>
    <div class="perfil-banner-box">
        <img src="{{ asset('img/img-instituicao/banners/' . ($instituicao->banner_user ?? 'banner.png')) }}" alt="Banner" class="perfil-banner-img">
        <div class="perfil-foto-box">
            <img src="{{ asset('img/img-instituicao/img-perfil/' . ($instituicao->img_user ?? 'img-perfil.png')) }}" alt="Foto" class="perfil-foto-img">
        </div>
    </div>
<div class="perfil-info-box">
    <div class="perfil-nome-arroba-box">
        <span class="perfil-nome">{{ $instituicao->nome_user ?? 'Nome da Instituição' }}</span>
        <span class="perfil-arroba">@ {{ $instituicao->arroba_user ?? 'usuario' }}</span>
        <span class="perfil-bio-box">{{ $instituicao->bio_user ?? 'Sua bio aqui...' }}</span>
        <div class="perfil-contagem-box">
            <span><b>{{ $instituicao->seguidores ?? 1 }}</b> <span class="contagem-label">Seguidores</span></span>
            <span><b>{{ $instituicao->seguindo ?? 0 }}</b> <span class="contagem-label">Seguindo</span></span>
        </div>
    </div>
    <button class="btn btn-primary btn-sm perfil-btn-editar">Editar perfil</button>
</div>
</div>

                <!-- Conta Institucional -->
<div class="card-conta">
    <div class="header">
        <img src="{{ asset('img/Icone_Logo_Cursei_Laranja.png') }}" style="width:38px; height:32px;">
        <span class="titulo titulo-laranja">Conta Institucional</span>
    </div>
    <div class="institucional-info">
        <div class="institucional-topo">
            <div>
                <span class="nome-inst">Etec de itaquera</span>
                <span class="cidade">Cidade/Estado</span><br>
                <span class="arroba-inst">@etecitaquera</span>
            </div>
            <button class="btn btn-primary btn-sm btn-editar-conta" onclick="abrirModalEditarConta()">Editar conta</button>
        </div>
        <div class="institucional-dados">
            <div>
                <div class="dado-label">CNPJ:</div>
                <div class="dado-valor">12.345.678/0001-90</div>
                <div class="dado-label">Telefone:</div>
                <div class="dado-valor">(11) 91234-5678</div>
            </div>
            <div>
                <div class="dado-label">Email:</div>
                <div class="dado-valor">etecitaquera@gmail.com</div>
                <div class="dado-label">Senha:</div>
                <div class="dado-valor">*********</div>
            </div>
        </div>
    </div>

            </div>
        </div>
    </main>

<div id="modal-editar-conta" class="modal-seguidores" style="display: none;">
    <div class="modal-conteudo modal-editar-conta">
        <div class="modal-header">
            <img src="{{ asset('img/Icone_Logo_Cursei_Laranja.png') }}" style="width:38px; height:32px;">
            <span class="modal-titulo">Registros da Conta</span>
        </div>
        <div class="modal-form-grid">
            <div class="form-group">
                <label for="cnpj">CNPJ</label>
                <input type="text" id="cnpj" class="form-control" value="12.345.678/0001-90" disabled>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" class="form-control" value="(11)91234-5678" disabled>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" value="etecitaquera@gmail.com" disabled>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" class="form-control" value="*********" disabled>
            </div>
        </div>
        <div class="modal-header" style="margin-top: 22px;">
            <img src="{{ asset('img/Icone_Logo_Cursei_Laranja.png') }}" style="width:38px; height:32px;">
            <span class="modal-titulo">Registro de Endereço</span>
        </div>
        <div class="modal-form-grid">
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" id="cep" class="form-control" value=",,,,," disabled>
            </div>
            <div class="form-group">
                <label for="logradouro">Logradouro</label>
                <input type="text" id="logradouro" class="form-control" value=",,,,," disabled>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <input type="text" id="estado" class="form-control" value=",,,," disabled>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" class="form-control" value=",,,," disabled>
            </div>
            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" class="form-control" value=",,,," disabled>
            </div>
            <div class="form-group">
                <label for="logradouro2">Rua</label>
                <input type="text" id="rua" class="form-control" value=",,,," disabled>
            </div>
            <div class="form-group">
                <label for="numero">Número</label>
                <input type="text" id="numero" class="form-control" value=",,,," disabled>
            </div>
            <div class="form-group">
                <label for="complemento">Complemento</label>
                <input type="text" id="complemento" class="form-control" value=",,,," disabled>
            </div>
        </div>
        <div class="modal-botoes">
            <button class="btn-cancelar" onclick="fecharModalEditarConta()">Cancelar</button>
            <button class="btn-confirmar" disabled>Salvar</button>
        </div>
    </div>
</div>

<script>
function abrirModalEditarConta() {
    document.getElementById('modal-editar-conta').style.display = 'flex';
}
function fecharModalEditarConta() {
    document.getElementById('modal-editar-conta').style.display = 'none';
}
// Fechar ao clicar fora do modal
document.addEventListener('click', function(e) {
    const modal = document.getElementById('modal-editar-conta');
    if (modal.style.display === 'flex') {
        if (e.target === modal) {
            fecharModalEditarConta();
        }
    }
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>