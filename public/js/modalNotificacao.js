
function abrirModalNotificacoes() {
    document.getElementById('modalNotificacoes').style.display = 'flex';
}

function fecharModalNotificacoes() {
    document.getElementById('modalNotificacoes').style.display = 'none';
}

// Fechar modal ao clicar fora
document.getElementById('modalNotificacoes').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharModalNotificacoes();
    }
});