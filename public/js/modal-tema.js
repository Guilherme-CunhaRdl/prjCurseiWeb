const containerModalTema = document.getElementById('containerModalTema')
const boxModal = document.getElementById('boxModalTema')

function abrirModalTema(){
    boxModal.classList.add('animacaoEntrada')   
    containerModalTema.classList.add('modal-ativo')
    containerModalTema.classList.remove('modal-oculto')
    console.log(containerModalTema)

}

function fecharModalTema(alvo){
    if(alvo.target === containerModalTema){
        setTimeout(()=>{
            boxModal.classList.add('animacaoSaida')

            boxModal.classList.remove('animacaoEntrada')
            boxModal.classList.remove('animacaoSaida')

            console.log(boxModal)

        }, 6000)
        containerModalTema.classList.remove('modal-ativo')
        containerModalTema.classList.add('modal-oculto')

    }else if(alvo.target === document.getElementById('botao-fechar-tema')){
        containerModalTema.classList.remove('modal-ativo')
        containerModalTema.classList.add('modal-oculto')
    }
    
    console.log(containerModalTema)
}