const modalInfo = document.getElementById("modal-perfil-info")
const contmodalInfo = document.getElementById("contmodalInfo")
function abrirModalAlterInfo() {
    contmodalInfo.style.display = "flex"
}


function fecharModalInfo(event) {
    // Fecha o modal apenas se o clique for fora da caixa do modal
    
    if (event.target === document.getElementById('contmodalInfo')) {
        // contmodalInfo.style.animation = "removerModalCont 500ms ease-in-out"
        // modalInfo.style.animation = "tiraModal 500ms ease-in-out"
        
        // setTimeout(() => {
        //     contmodalInfo.style.display = "none"
            
        // }, 450);
        contmodalInfo.style.display ="none"
    }
}

