let idCurtei
function verCurtei(legenda, video, capa, id) {
    idCurtei = id
    document.getElementById('contModalverCurtei').style.display = 'flex'
    document.querySelector('#contModalverCurtei textarea').value = legenda;
    console.log(video)
    document.getElementById('source').src = video;
document.getElementById('imgEditCurtei').src = capa;

}
function fecharCurtei() {
    document.getElementById('contModalverCurtei').style.display = 'none'
    document.querySelector('#contModalverCurtei textarea').value = "";
    document.getElementById('source').src = "";
}
function ativarEdit() {
    document.querySelector('#contModalverCurtei textarea').disabled = false;
    document.querySelector('#contModalverCurtei .bx-x').style.display = 'none';
    document.getElementById('editandoP').style.display = 'block'
    document.getElementById('cancelarBtn').style.display = 'block'
    document.getElementById('labelEditVideo').style.display = 'block';

    document.getElementById('salvaBtn').style.display = 'block'
    document.getElementById('imgBtn').style.display = 'block'
    document.getElementById('sairBtn').style.display = 'none'
    document.getElementById('editBtn').style.display = 'none'
    document.getElementById('backBtn').style.display = 'none'

}
function desativarEdit() {
    document.querySelector('#contModalverCurtei textarea').disabled = true;
    document.querySelector('#contModalverCurtei .bx-x').style.display = 'block';
    document.getElementById('editandoP').style.display = 'none';
    document.getElementById('cancelarBtn').style.display = 'none';
    document.getElementById('salvaBtn').style.display = 'none';
    document.getElementById('imgBtn').style.display = 'none';
    document.getElementById('labelEditVideo').style.display = 'none';


    document.getElementById('sairBtn').style.display = 'block';
    document.getElementById('editBtn').style.display = 'block';
    document.getElementById('backBtn').style.display = 'block';
}
function editarThumb() {
    document.getElementById('source').style.display = 'none'
    document.getElementById('imgModalVerPost').style.display = 'block'
    document.getElementById('imgBtn').style.display = 'none';
    document.getElementById('videoBtn').style.display = 'block';
    document.getElementById('labelEditVideo').style.display = 'none';


}
function editarVideo() {
    document.getElementById('source').style.display = 'block'
    document.getElementById('imgModalVerPost').style.display = 'none'
    document.getElementById('imgBtn').style.display = 'block';
    document.getElementById('videoBtn').style.display = 'none';
        document.getElementById('labelEditVideo').style.display = 'block';

}
document.getElementById('inputcapa').addEventListener('change', readImage, false);

function readImage() {
    if (this.files && this.files[0]) {
        var file = new FileReader();

        file.onload = function (e) {
            document.getElementById('imgEditCurtei').src = e.target.result;

        };
        file.readAsDataURL(this.files[0])
    }
}
document.getElementById('inputVideoEdit').addEventListener('change', readImageVideo, false);

function readImageVideo() {
    if (this.files && this.files[0]) {
        var file = new FileReader();

        file.onload = function (e) {
            document.getElementById('source').src = e.target.result;

        };
        file.readAsDataURL(this.files[0])
    }
}
const formUpdate = document.getElementById("formUpdate")

async function salvar() {
    const update = new FormData(formUpdate)
    try{
            const result = await axios.post(`http://${host}/api/curtei/update/${idCurtei}`, update)
            desativarEdit();
            carregarCurteis();
    }
    catch(error){
        alert('Erro de conexão')
    }
}


function abrirModalDesativar() {
    // Criar overlay
    const overlay = document.createElement('div');
    overlay.className = 'overlay-modal';

    // Criar caixa do modal
    overlay.innerHTML = `
      <div class="modal-box">
        <h4>Deseja desativar esse Curtei?</h4>
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
    try {
        const result = axios.delete(`http://${host}/api/curtei/deletar/${idCurtei}`)
        carregarCurteis()
        fecharCurtei()
    }
    catch (error) {
        alert('erro de conexão')
    }


}