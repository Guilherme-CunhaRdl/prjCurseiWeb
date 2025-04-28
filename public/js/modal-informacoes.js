const containerModalInformacoes = document.getElementById('containerModalInformacoes')
const boxModalInformacoes = document.getElementById('boxModalInformacoes')

function abrirModalInformacoes(){
    boxModalInformacoes.classList.add('animacaoEntrada')   

    containerModalInformacoes.classList.add('modal-ativo')
    containerModalInformacoes.classList.remove('modal-oculto')
    console.log(containerModalInformacoes)

}

function fecharModalInformacoes(alvo){
    if(alvo.target === containerModalInformacoes){
        containerModalInformacoes.classList.remove('modal-ativo')
        containerModalInformacoes.classList.add('modal-oculto')

        setTimeout(()=>{
            containserModalInformacoes.style.animation = 'fadeOut 0.5s ease-in forwards';
        }, 6000)
    }else if(alvo.target === document.getElementById('botao-fechar-informacoes')){
        containerModalInformacoes.classList.remove('modal-ativo')
        containerModalInformacoes.classList.add('modal-oculto')
    }
    
    console.log(containerModalInformacoes)
}