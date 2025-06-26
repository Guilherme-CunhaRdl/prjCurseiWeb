
function abrirModalNotificacoes(idUser, acao) {
    document.getElementById('modalNotificacoes').style.display = 'flex';
        const loading = document.getElementById("contLoad");

    loading.style.display = 'flex'; 

    axios.get(`http://localhost:8000/api/cursei/user/notificacao/${idUser}/${acao}`)
        .then(response => {
            const notificacoes = response.data.ultimos_7_dias;
            console.log(notificacoes)
            const container = document.getElementById("listaNotificacoes");

            container.innerHTML = '';
            notificacoes.forEach(n => {
                const icone = {
                    'curtida': 'bx-like',
                    'comentario': 'bx-comment',
                    'seguido': 'bx-user-plus',
                    'repost': 'bi bi-repeat'
                }[n.tipo] || 'bx-bell';
                
                loading.style.display = 'none'; 

                container.innerHTML += `
                    <div class="notificacao-item">
                        <div class="notificacao-icone">
                            <i class='bx ${icone}'></i>
                        </div>
                        <div class="notificacao-conteudo">
                            <p><strong>${n.usuario}</strong> ${
                                    n.tipo === 'curtida' ? 
                                    `Curtiu Seu Post` : 
                                    n.tipo === 'comentario' ?
                                    'Comentou no Seu Post' : 
                                    n.tipo === 'seguido' ?
                                    'Começou a Te seguir':
                                    n.tipo ==='repost' ?
                                    'Repostou Seu Post':
                                    "paia"}
                             </p>
                            <span class="notificacao-tempo">${n.tempo_inserido}</span>
                        </div>
                    </div>
                `;
            });
        })

        .catch(error => {
            console.error("Erro ao buscar notificações:", error);
        });

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