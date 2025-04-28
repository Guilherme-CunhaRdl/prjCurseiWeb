
const modal = document.getElementById("modal-perfil")
const contmodal = document.getElementById("contmodal")
function abrirModalAlter() {
    contmodal.style.display = "flex"
}


function fecharModal(event) {
    // Fecha o modal apenas se o clique for fora da caixa do modal
    if (event.target === document.getElementById('contmodal')) {
        contmodal.style.animation = "removerModalCont 500ms ease-in-out"
        modal.style.animation = "tiraModal 500ms ease-in-out"
        setTimeout(() => {
            contmodal.style.animation = "aparecerModalCont 300ms ease-in-out"
            contmodal.style.display = "none"
            modal.style.animation = "aparecerModal 800ms ease-in-out"

        }, 450);
    }
}
const contVerificar = document.querySelector('.cont-modal-verificar');
const modalVerificar = document.querySelector('.modal-verificar');

function abrirModalVerficar(){
    contVerificar.style.display ="flex";
}
function fecharModalVerificar(event){
    if (event.target === contVerificar) {
        contVerificar.style.animation = "removerModalCont 500ms ease-in-out"
        modalVerificar.style.animation = "tiraModal 500ms ease-in-out"
        setTimeout(() => {
            contVerificar.style.animation = "aparecerModalCont 300ms ease-in-out"
            contVerificar.style.display = "none"
            modalVerificar.style.animation = "aparecerModal 800ms ease-in-out"

        }, 450);
    }
}