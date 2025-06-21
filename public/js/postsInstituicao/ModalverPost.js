var idPost = null
var evento = false

async function verPost(id, desc, img, idEvento) {

    if (idEvento) {
        evento = true
        document.getElementById('postUpdateNormal').style.display = 'none'
        document.getElementById('eventoUpdate').style.display = 'block'
        document.getElementById('modalPotsView').style.width = '35%'
        response = await axios.get(`http://${host}/api/cursei/evento/${idEvento}`)
        document.getElementById('previewCapaUpdate').src = `http://${host}/img/user/imgPosts/${response.data[0].conteudo_post}`
        document.getElementById('previewCapaUpdate').style.display = 'block'
        document.getElementById('idEvendoInputHiddenUpdate').value = idEvento;
        document.getElementById('tituloEventoUpdate').value = response.data[0].descricao_post;
        document.getElementById('linkUpdate').value = response.data[0].link_evento;
        document.getElementById('descEventoUpdate').value = response.data[0].desc_evento;
        const [dataInicio, horaInicio] = response.data[0].data_inicio_evento.split(' ');
        document.getElementById('inicioUpdate').value = dataInicio;
        document.getElementById('hinicioUpdate').value = horaInicio;
        const [dataFim, horaFim] = response.data[0].data_fim_evento.split(' ');
        document.getElementById('fimUpdate').value = dataFim;
        document.getElementById('hfimUpdate').value = horaFim;
        document.getElementById('addLinkUpdateButton').style.display = 'none'

    } else {
        evento = false
        document.getElementById('postUpdateNormal').style.display = 'block'
        document.getElementById('eventoUpdate').style.display = 'none'
        document.getElementById('modalPotsView').style.width = '32%'
        document.getElementById('addLinkUpdateButton').style.display = 'block'

    }
    idPost = id
    document.getElementById("viewPost").style.display = "flex"
    if (img) {
        document.getElementById('imgModalVerPost').style.display = "flex"
        document.getElementById('imgPostVisualizacao').src = `http://${host}/img/user/imgPosts/${img}`
        document.getElementById('addImgLabelVerModal').style.display = "none"

    } else {
        document.getElementById('imgModalVerPost').style.display = "none"

    }
    if (desc != "null") {
        document.getElementById('descPostModal').style.display = "flex"
        document.getElementById('descPostModal').value = desc
    } else {
        document.getElementById('descPostModal').style.display = "none"

    }

}
function fecharModalVerPost() {
    document.getElementById("viewPost").style.display = "none"
    desativarEdicao()
}

function ativarEdicao() {
    if (evento) {
        document.getElementById('labelAlterCapa').style.display = 'flex'
        document.getElementById('inicioUpdate').disabled = false
        document.getElementById('hinicioUpdate').disabled = false
        document.getElementById('fimUpdate').disabled = false
        document.getElementById('hfimUpdate').disabled = false
        document.getElementById('tituloEventoUpdate').disabled = false
        document.getElementById('linkUpdate').disabled = false
        document.getElementById('descEventoUpdate').disabled = false

    } else {

        document.getElementById('descPostModal').disabled = false;
    }
    document.getElementById('normal').style.display = 'none'
    document.getElementById('editando').style.display = 'flex'
    document.getElementById('labelImgUpdate').style.display = 'flex'
    document.getElementById('iconeX').style.display = 'none'
    document.getElementById('editandoP').style.display = 'block'

}
function desativarEdicao() {
    document.getElementById('normal').style.display = 'flex'
    document.getElementById('editando').style.display = 'none'
    document.getElementById('labelImgUpdate').style.display = 'none'
    document.getElementById('iconeX').style.display = 'block'
    document.getElementById('editandoP').style.display = 'none'
    if (evento) {
        document.getElementById('labelAlterCapa').style.display = 'none'

        document.getElementById('inicioUpdate').disabled = true
        document.getElementById('hinicioUpdate').disabled = true
        document.getElementById('fimUpdate').disabled = true
        document.getElementById('hfimUpdate').disabled = true
        document.getElementById('tituloEventoUpdate').disabled = true
        document.getElementById('linkUpdate').disabled = true
        document.getElementById('descEventoUpdate').disabled = true
    } else {

        document.getElementById('descPostModal').disabled = true;
    }


}
document.getElementById('imgUpdate').addEventListener('change', readImagePost, false);
document.getElementById('inputcapaUpdate').addEventListener('change', readImageEvento, false);


function readImageEvento() {
    if (this.files && this.files[0]) {
        var file = new FileReader();

        file.onload = function (e) {
            document.getElementById('previewCapaUpdate').src = e.target.result;
            document.getElementById('previewCapaUpdate').style.display = 'block'


        };
        file.readAsDataURL(this.files[0])
    }
}
function readImagePost() {
    if (this.files && this.files[0]) {
        var file = new FileReader();

        file.onload = function (e) {
            document.getElementById('imgPostVisualizacao').src = e.target.result;
            document.getElementById('imgModalVerPost').style.display = "flex"
            document.getElementById('addImgLabelVerModal').style.display = "none"

        };
        file.readAsDataURL(this.files[0])
    }
}

const formUpdate = document.getElementById('postUpdateNormal')
const eventoUpdate = document.getElementById('eventoUpdate')

async function salvar() {
    let url, update;

    if (evento) {
        update = new FormData(eventoUpdate)
        url = `http://${host}/api/cursei/eventoUpdate`
    } else {
        update = new FormData(formUpdate)
        url = `http://${host}/api/cursei/postsUpdate/${idPost}`
    }
    try {
        const result = await axios.post(url, update)
        desativarEdicao()
        carregarPost()
    } catch (error) {
        alert('erro de conexão')
        const jsonObj = {};
        update.forEach((value, key) => {
            jsonObj[key] = value;
        });
        console.log(JSON.stringify(jsonObj, null, 2));
    }
}





function abrirModalDesativar() {
    // Criar overlay
    const overlay = document.createElement('div');
    overlay.className = 'overlay-modal';

    // Criar caixa do modal
    overlay.innerHTML = `
      <div class="modal-box">
        <h4>Deseja desativar esse post?</h4>
        <p>Ao desativar esse post ele não poderá ser visualizado</p>
        <div class="modal-buttons">
          <button class="cancel-btn">Cancelar</button>
          <button class="deactivate-btn">Desativar</button>
        </div>
      </div>
    `;

    // Adicionar ao body
    document.body.appendChild(overlay);

    // Botão cancelar
    overlay.querySelector('.cancel-btn').onclick = () => {
        document.body.removeChild(overlay);
    };

    // Botão desativar
    overlay.querySelector('.deactivate-btn').onclick = () => {
        desativar()
        document.body.removeChild(overlay);
    };
}
function desativar() {
    const dados = {
        idPost: idPost
    }
    try {
        const result = axios.post(`http://${host}/api/posts/interacoes/desativar`, dados)
        carregarPost()
        fecharModalVerPost()
    }
    catch (error) {
        alert('erro de conexão')
    }


}



