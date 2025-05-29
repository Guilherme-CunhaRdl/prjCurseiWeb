const containerModalCriarPost = document.getElementById('containerModalCriarPost')
const boxModalCriarPost = document.getElementById('boxModalCriarPost')

function abrirModalCriarPost(){

    containerModalCriarPost.classList.add('modal-ativo')
    containerModalCriarPost.classList.remove('modal-oculto')
    console.log(containerModalCriarPost)

}

function fecharModalCriarPost(alvo){
    console.log(alvo)
    if(alvo.target === containerModalCriarPost){
        containerModalCriarPost.classList.remove('modal-ativo')
        containerModalCriarPost.classList.add('modal-oculto')
    }else if(alvo.target === document.getElementById('botaoFecharModalCriacao')){
        containerModalCriarPost.classList.remove('modal-ativo')
        containerModalCriarPost.classList.add('modal-oculto')

    }
    
    console.log(containerModalCriarPost)
}