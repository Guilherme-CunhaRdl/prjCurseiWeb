const containerModalInformacoes = document.getElementById('containerModalInformacoes')
const boxModalInformacoes = document.getElementById('boxModalInformacoes')

function abrirModalInformacoes(){

    containerModalInformacoes.classList.add('modal-ativo')
    containerModalInformacoes.classList.remove('modal-oculto')
    console.log(containerModalInformacoes)

}

function fecharModalInformacoes(alvo){
    if(alvo.target === containerModalInformacoes){
        containerModalInformacoes.classList.remove('modal-ativo')
        containerModalInformacoes.classList.add('modal-oculto')
    }else if(alvo.target === document.getElementById('botao-fechar-informacoes')){
        containerModalInformacoes.classList.remove('modal-ativo')
        containerModalInformacoes.classList.add('modal-oculto')
    }
    
    console.log(containerModalInformacoes)
}