countNotificacoes(idInstituicao, 'count')

async function countNotificacoes(idUser, acao){

    const resposta = await axios.get(`http://localhost:8000/api/cursei/user/notificacao/${idUser}/${acao}`);

    console.log(resposta.data)

    document.getElementById('qtdNotificacao').innerText = resposta.data

}