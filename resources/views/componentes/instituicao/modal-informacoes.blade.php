<div class="container-fluid container-modal-informacoes modal-oculto" id="containerModalInformacoes" onclick="fecharModalInformacoes(event)">
    <div class="box-modal-informacoes" id="boxModalInformacoes">
        <div class="col-12 header-modal-informacoes">
            <div class="d-flex flex-row justify-content-between align-items-center">
            <h1>Informações da Instituição</h1>
            <button onclick="fecharModalInformacoes(event)" style="background-color: transparent; border: none;" id="botao-fechar-informacoes">
            <i class="bi bi-x" style="font-size: 2rem; pointer-events: none;"></i>
            </button>
            </div>
            <hr class="mt-0">
        </div>
            
        <div class="conteudo-modal-informacoes">
            <div class="col-12 d-flex flex-row justify-content-evenly">
                <div class="col-6 text-start">
                    <ul class="p-0 ps-5">
                        <li>Nome: {{$instituicao->nome_user}}</li>
                        <li>Email: {{$instituicao->email_user}}</li>
                        <li>Arroba: {{$instituicao->arroba_user}}</li>

                        <li>Logradouro: {{$instituicao->instituicao->logradouro_instituicao}}</li>
                        <li>CNPJ: {{$instituicao->instituicao->cnpj_instituicao}}</li>
                        <li>Verificado: {{$instituicao->instituicao->verificado_instituicao ? 'Sim' : 'Não'}}</li>
                    </ul>
                </div>
                <div class="col-6 text-start">
                    <ul class="p-0 ps-5">
                        <li>Numero Logradouro: {{$instituicao->instituicao->num_logradouro_instituicao}}</li>
                        <li>Bairro: {{$instituicao->instituicao->bairro_instituicao}}</li>
                        <li>Cidade: {{$instituicao->instituicao->cidade_instituicao}}</li>
                        <li>Estado: {{$instituicao->instituicao->estado_instituicao}}</li>
                        <li>Cep: {{$instituicao->instituicao->cep_instituicao}}</li>
                        <li>Complemento: {{$instituicao->instituicao->complemento_instituicao}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-12 d-flex flex-row justify-content-evenly">
                <div class="div-datas d-flex flex-column col-6 text-start ps-5">
                    <span>Criado Em: </span>
                    <span style="color: var(--cor-tema);"> {{ $instituicao->created_at }} </span>
                </div>
                <div class="div-datas col-6 d-flex flex-column text-start ps-5">
                    <span>Atualizado Em: </span>
                    <span style="color: var(--cor-tema);">{{ $instituicao->updated_at }}</span>
                </div>
            </div>

            <div class="div-label-bio mt-3">
                <span>Bio</span>
            </div>
            <div class="div-bio mb-4">
                <span>{{$instituicao->bio_user}}</span>
            </div>
        </div>

        
    </div>
</div>